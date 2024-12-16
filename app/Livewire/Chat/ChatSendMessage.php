<?php

namespace App\Livewire\Chat;

use App\Events\MessageSent;
use App\Models\Conversation;
use App\Models\EmployeeDetails;
use App\Models\Message;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Str;

class ChatSendMessage extends Component
{
    use WithFileUploads;

    public $selectedConversation;
    public $receiverInstance;
    public $body;
    public $media = [];
    public $createdMessage;
    public $mediaPreviews = [];

    protected $listeners = ['updateSendMessage', 'dispatchMessageSent', 'resetComponent', 'emojiBody'];

    public function resetComponent()
    {
        $this->selectedConversation = null;
        $this->receiverInstance = null;
    }

    public function updateSendMessage(Conversation $conversation, EmployeeDetails $receiver)
    {
        $this->selectedConversation = $conversation;
        $this->receiverInstance = $receiver;
    }

    public function emojiBody($emoji)
    {
        $this->body .= $emoji;
    }



    public function deleteMedia($index)
    {
        // Remove the media from the array
        unset($this->media[$index]);

        // Re-index the array to maintain continuous keys
        $this->media = array_values($this->media);

        // Call the updatedMedia method to refresh the preview and body
        $this->updatedMedia();
    }


    public function clearError()
    {
        session()->forget('error'); // This clears the error session
    }

    public function updatedMedia()
    {
        $this->mediaPreviews = [];
        $fileNames = [];

        foreach ($this->media as $file) {
            $mimeType = $file->getMimeType();
            if (str_starts_with($mimeType, 'image/')) {
                // Image preview
                $this->mediaPreviews[] = ['type' => 'image', 'url' => $file->temporaryUrl()];
            } else {
                // Non-image file preview (showing the file name with a file icon)
                $this->mediaPreviews[] = [
                    'type' => 'file',
                    'icon' => 'fas fa-file fa-3x', // FontAwesome icon for files
                    'fileName' => $file->getClientOriginalName()
                ];
            }
            $fileNames[] = $file->getClientOriginalName(); // Get the original file name
        }

        // Append the file names to the message body
        $this->body = implode(', ', $fileNames) . ' ';
    }


    public function sendMessage()
    {
        $trimmedBody = trim($this->body);

        if (empty($trimmedBody) && empty($this->media)) {
            session()->flash('error', 'Message cannot be empty. Please enter text, an emoji, or attach a file.');
            // $this->dispatch('show-error', ['message'=>'Message cannot be empty. Please enter text, an emoji, or attach a file.']);
            // $this->dispatch('show-error', ['message' => 'Message cannot be empty']);
            return;
        }

        $mediaPaths = [];
        $mediaType = null;

        if ($this->media) {
            $this->validate([
                'media' => 'array|max:5', // Allow multiple files (maximum 5 files)
                'media.*' => 'file|max:1024|mimes:jpg,jpeg,png,gif,webp,pdf,zip,docx,xlsx', // Individual file validation
            ]);

            foreach ($this->media as $file) {
                // Generate filename with date, time, and a unique ID
                $timestamp = now()->format('Y-m-d_H-i-s'); // Get the current timestamp
                $uniqueId = Str::random(8); // Shorter, random unique ID
                $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME); // Get the original file name without extension
                $extension = $file->getClientOriginalExtension(); // Get the file extension
                $filename = $timestamp . '_' . $uniqueId . '_' . $originalName . '.' . $extension; // Concatenate timestamp, unique ID, original filename, and extension

                $mediaPaths[] = $file->storeAs('uploads/messages', $filename, 'public'); // Store file with new unique filename

                // Detect MIME type and set media type accordingly
                $mimeType = $file->getMimeType();
                if (str_contains($mimeType, 'image')) {
                    $mediaType = 'image';
                } elseif (str_contains($mimeType, 'video')) {
                    $mediaType = 'video';
                } elseif (str_contains($mimeType, 'pdf')) {
                    $mediaType = 'pdf';
                } elseif (str_contains($mimeType, 'zip')) {
                    $mediaType = 'zip';
                } elseif (str_contains($mimeType, 'msword') || str_contains($mimeType, 'officedocument')) {
                    $mediaType = 'document';
                } else {
                    $mediaType = 'file'; // Default for other types of files
                }
            }
        }

        // If no media was uploaded, set $mediaPaths to null
        $encodedMediaPaths = $mediaPaths ? json_encode($mediaPaths) : null;

        // Replace escaped slashes only if $encodedMediaPaths is not null
        if ($encodedMediaPaths) {
            $encodedMediaPaths = str_replace('\/', '/', $encodedMediaPaths);
        }

        $this->createdMessage = Message::create([
            'conversation_id' => $this->selectedConversation->id,
            'sender_id' => auth()->id(),
            'receiver_id' => $this->receiverInstance->emp_id,
            'body' => $trimmedBody ?? '',
            'media_path' => $encodedMediaPaths, // This would store the paths as a JSON-encoded array or null
            'type' => $mediaType, // Save the media type (image, video, pdf, document, etc.)
        ]);

        if (auth()->id() === $this->receiverInstance->emp_id) {
            $this->createdMessage->read = 1;
            $this->createdMessage->save();
        }

        $this->selectedConversation->last_time_message = $this->createdMessage->created_at;
        $this->selectedConversation->save();

        $this->dispatch('pushMessage', $this->createdMessage->id)->to('chat.chat-box');
        $this->dispatch('show-toast', ['message' => $trimmedBody]);
        $this->dispatch('sendMessageSound'); // Emit send sound event
        $this->dispatch('refresh')->to('chat.chat-list');
        $this->reset(['body', 'media', 'mediaPreviews']);
        $this->dispatch('dispatchMessageSent')->self();
    }



    public function dispatchMessageSent()
    {
         broadcast(new MessageSent(Auth()->user(), $this->createdMessage, $this->selectedConversation, $this->receiverInstance));
        // MessageSent::dispatch(Auth()->user(), $this->createdMessage, $this->selectedConversation, $this->receiverInstance);
    }

    public function render()
    {
        return view('livewire.chat.chat-send-message');
    }
}
