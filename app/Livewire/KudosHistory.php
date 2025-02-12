<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Kudos;
use Illuminate\Support\Facades\Auth;
use App\Models\EmployeeDetails;
use App\Helpers\FlashMessageHelper;

class KudosHistory extends Component
{
    public $activeTab = 'Recieved';
    public $kudos=[];
    public $showKudoEmojiPicker = [];
    public $showDialogReactions = false;
    public $showOptions = [];
    public $postType = 'everyone';
    public $recognizeType = []; 
    public $message = '';
    public $selectedEmployee = null;
    public $reactions = []; 
    public $showKudosDialog = false;
    public $kudoId = null;
    public $dropdownOpen = false; 
    public $showKudoEmojiPicker1 = false; 
    public $kudosId; 
    public function validateKudos(){
        $this->validate([
           'message' => 'required|string|min:5',
        'selectedEmployee' => 'required',
         
        
        ]);
    } 
    public $allEmojis = [];
    public function updateKudosemojiReactions()
    {
        $kudo = Kudos::find($this->kudoId); // Or pass the ID if needed
        $this->allEmojis = json_decode($kudo->reactions, true); // Update the reactions list in Livewire component
    }
    public function removeReaction($employeeId, $emoji, $kudoId, $createdAt)
    {
        // Ensure the reaction is from the logged-in employee
        if ($employeeId === auth()->user()->emp_id) {

            // Find the Kudos record by ID (ensure $this->kudoId is set correctly)
            $kudo = Kudos::find($kudoId);

            if (!$kudo) {
                // Handle case where the Kudos entry is not found (optional but recommended for safety)
                FlashMessageHelper::flashError('Kudos not found!');
                return;
            }

            // Decode the reactions field to get an array of reactions
            $reactions = json_decode($kudo->reactions, true);

            // Check if reactions exist and are an array
            if (is_array($reactions)) {
                // Filter out the reaction by employee_id, emoji, and created_at value
                foreach ($reactions as $index => $reaction) {
                    if (
                        $reaction['employee_id'] === $employeeId &&
                        $reaction['emoji'] === $emoji &&
                        $reaction['created_at'] === $createdAt
                    ) {

                        unset($reactions[$index]); // Remove the exact match
                        break; // Stop after removing the first matching reaction
                    }
                }

                // Reindex the array after filtering to avoid skipped indexes
                $reactions = array_values($reactions);

                // Save the updated reactions back to the database
                $kudo->reactions = json_encode($reactions);
                $kudo->save();

                $this->updateKudosemojiReactions();
                // Optionally, you can emit an event to notify Livewire or the front-end if needed
                FlashMessageHelper::flashSuccess('Reaction removed successfully!');
            } else {
                // If reactions is not an array or is empty
                FlashMessageHelper::flashError('No reactions found to remove!');
            }
        } else {
            // Handle the case where the employee is not authorized to remove this reaction
            FlashMessageHelper::flashError('You are not authorized to remove this reaction.');
        }
    }
    public function closeEmojiReactions()
    {

        $this->showDialogReactions = false;
        $this->mount();
    }
    public function showReactions($reactions, $kudoId)
    {
        $this->kudoId = $kudoId;
        $this->allEmojis = $reactions;
        $this->showDialogReactions = true;
        $this->mount();
    }
    public function submitKudos()
    {
        $validatedData = $this->validateKudos();


      

        // Ensure recognizeType and reactions are properly encoded as JSON
        $recognizeTypeJson = !empty($this->recognizeType) ? json_encode($this->recognizeType) : null;
        $reactionsJson = !empty($this->reactions) ? json_encode($this->reactions) : null;

        // Check if we are in edit mode by looking for the existing kudo ID
        if (isset($this->kudoId)) {
           

            // Update the existing Kudos entry
            $kudo = Kudos::find($this->kudoId);

            if ($kudo) {
                $kudo->employee_id = Auth::user()->emp_id;  // Update the employee who gave the Kudos
                $kudo->recipient_id = $this->selectedEmployee->emp_id;  // Update recipient
                $kudo->message = $this->message;  // Update the message
                $kudo->recognize_type = $recognizeTypeJson;  // Update recognize type
                $kudo->reactions = $reactionsJson;  // Update reactions
                $kudo->post_type = $this->postType;  // Update post type

                // Save the updated record
                $kudo->save();



                // Optionally, flash a success message
                FlashMessageHelper::flashSuccess('Kudos updated successfully!');
                $this->showKudosDialog = false;
                // session()->flash('message', '');
            }
        } else {
            // Create a new Kudos entry if kudoId is not set (new entry)
            Kudos::create([
                'employee_id' => Auth::user()->emp_id,  // Assuming the logged-in employee
                'recipient_id' => $this->selectedEmployee->emp_id,
                'message' => $this->message,
                'recognize_type' => $recognizeTypeJson,  // Save the encoded JSON
                'reactions' => $reactionsJson,  // Save the encoded JSON
                'post_type' => $this->postType,  // Save the postType
            ]);

            // Optionally, flash a success message
            // session()->flash('message', 'Kudos given successfully!');
            FlashMessageHelper::flashSuccess('Kudos given successfully!');
            $this->showKudosDialog = false;
        }
        $this->mount();

        // Reset form fields after submission
        $this->resetFields();
    }

    public function setActiveTab($tab)
    {
        if ($tab === 'Recieved') {
            $this->activeTab = 'Recieved';
            $this->mount();
        }
      else{
            $this->activeTab = 'Given';
            $this->mount();
        }
    }
    public function toggleKudosEmojiPicker1()
    {
        $this->showKudoEmojiPicker1 = !$this->showKudoEmojiPicker1;
    }
    public function addReaction($reaction)
    {
        // Ensure the reaction is not already in the reactions array
        if (!in_array($reaction, array_column($this->reactions, 'emoji'))) {
            // Add the reaction emoji along with employee_id and timestamp to the reactions array
            $reactionData = [
                'emoji' => $this->reactionEmojis[$reaction],  // Emoji character
                'employee_id' => Auth::user()->emp_id,        // Employee who reacted
                'created_at' => now(),                         // Timestamp
            ];

            // Add the reaction to the array
            $this->reactions[] = $reactionData;
        }

        // Close the emoji picker after selection
        $this->showKudoEmojiPicker1 = false;

        // Optionally, update the kudos reactions in the kudos table when a reaction is added
        $this->updateKudosReactions();
    }
    public function editKudo($kudoId)
    {
    
        // Fetch kudo details by ID
        $kudo = Kudos::find($kudoId);

        // Check if the kudo exists
        if ($kudo) {
            // Get the post type and other details from the kudo
            $this->postType = $kudo->post_type;

            // Decode recognize_type field to an array (if it's a JSON string)
            $this->recognizeType = (array)json_decode($kudo->recognize_type, true); // Decodes the JSON string to an array

            // Get the message
            $this->message = $kudo->message;

            // Fetch the recipient details using the recipient_id
            $this->selectedEmployee = EmployeeDetails::where('emp_id', $kudo->recipient_id)->first(); // Assuming 'emp_id' is the primary key in the Employee model

            // Decode reactions field from JSON to array (if it's a JSON string)
            $this->reactions = (array)json_decode($kudo->reactions, true); // Decodes the reactions to an array
            // $this->reactions = array_column($this->reactions, 'emoji');

        }
        $reactionEmojis = $this->reactionEmojis;



        // Open the modal
        $this->showKudosDialog = true;
        $this->showOptions = [];

        // Optionally call the mount() method to reset fields or state as necessary
        $this->mount();
    }
    public function confirmDelete($kudoId)
    {

        // Delete the Kudo from the database
        $kudo = Kudos::find($kudoId);
        if ($kudo && $kudo->sender_id == auth()->user()->id) {
            $kudo->delete();
            // session()->flash('message', 'Kudo deleted successfully.');
            FlashMessageHelper::flashSuccess('Kudo deleted successfully.');
        }
        $this->mount();
        $this->showModal[$kudoId] = false;  // Close modal after delete
    }
    public function close()
    {
        $this->showKudosDialog = false;
        $this->mount();
        $this->resetFields();
    }
    public function resetFields()
    {
        $this->message = '';
        $this->selectedEmployee = null;
        $this->postType = 'everyone';
        $this->recognizeType = [];
        $this->reactions = [];
    }
    public $recognizeOptions = [];
    public $options = [
        'Approachable' => 'You work well with others',
        'Articulate' => 'You can express yourself well in front of groups.',
        'Autonomous' => 'You are a self-starter with lots of initiative and agency.',
        'Collaborator' => 'You are a teamwork champion and culture builder.',
        'Competitive' => 'You thrive under pressure.',
        'Creative' => 'You are the endless source of original ideas.',
        'Devoted' => 'You are committed to the company\'s success.',
        'Efficient' => 'You have a very quick turnaround time.',
        'Enthusiastic' => 'You put all in every project.',
        'Independent' => 'You need a little direction.',
        'Innovator' => 'You are the visionary boundary-pusher.',
        'Leader' => 'You set an example for an exemplary role model and empowerer.',
        'Learner' => 'You can learn new things and put that learning to good use.',
        'Motivator' => 'You are the true inspiration and change driver.',
        'Open-minded' => 'You take constructive criticism well.',
        'Opinionated' => 'You are comfortable voicing opinions.',
        'Planning' => 'You can come up with a good plan for a project or initiative.',
        'Problem Solver' => 'You can solve problems in the most elegant and effective manner.',
        'Resourceful' => 'You use every tool at hand.',
        'Strategist' => 'You have the planning mastery with clear vision.',
        'Team Player' => 'You foster unity and team binding.',
    ];
    public $searchTerm = ''; 
    public function recognizeToggleDropdown()
    {
        $this->dropdownOpen = !$this->dropdownOpen;  // Toggle dropdown visibility
        $this->searchTerm="";
    }
    public function searchRecognizeValues()
    {
        if ($this->searchTerm) {
            $filteredOptions = collect($this->options)
                ->filter(function ($value, $key) {
                    return strpos(strtolower($key), strtolower($this->searchTerm)) !== false;
                })
                ->toArray();
            $this->recognizeOptions =   $filteredOptions;
        } else {
            $this->recognizeOptions = $this->options;
        }
    }
    public function removeItem($type)
    {
        $this->recognizeType = array_filter($this->recognizeType, function ($item) use ($type) {
            return $item !== $type;
        });
        $this->recognizeType = array_values($this->recognizeType); // Reindex array
    }
    public function removeKudosReaction($employeeId, $emoji)
    {


        // Filter out the specific emoji for the given employee_id from the reactions array
        $this->reactions = array_filter($this->reactions, function ($reaction) use ($employeeId, $emoji) {
            return !($reaction['employee_id'] === $employeeId && $reaction['emoji'] === $emoji);
        });

        // Re-index the array after filtering to avoid gaps in the keys
        $this->reactions = array_values($this->reactions);

        // Optionally, update the model if needed (e.g., updating the kudos table)
        $this->updateKudosReactions();
    }
    private function updateKudosReactions()
    {
        // Encode reactions array as JSON
        $encodedReactions = json_encode($this->reactions);

        // Update the kudos table with the new reactions
        Kudos::where('id', $this->kudosId)->update(['reactions' => $encodedReactions]);
    }
    public function addReaction1($reactionKey, $kudoId)
    {
        // Ensure the reaction key exists in the $reactionEmojis array
        if (!array_key_exists($reactionKey, $this->reactionEmojis)) {
            session()->flash('error', 'Invalid reaction!');
            return;
        }
    
        // Get the emoji corresponding to the reaction key
        $emoji = $this->reactionEmojis[$reactionKey];
    
        // Fetch the kudo record by kudoId
        $kudo = Kudos::find($kudoId);
    
        // Check if the kudo exists
        if (!$kudo) {
            session()->flash('error', 'Kudo not found!');
            return;
        }
    
        // Decode the existing reactions from JSON to an array
        $reactions = json_decode($kudo->reactions, true) ?? [];
    
        // Find the reaction for the current user (if any)
        $userReactions = array_filter($reactions, function($reaction) {
            return $reaction['employee_id'] === Auth::user()->emp_id;
        });
    
        // If there are multiple reactions by the same user, get the most recent one
        if (!empty($userReactions)) {
            // Sort the user's reactions by 'created_at' in descending order (most recent first)
            usort($userReactions, function($a, $b) {
                return strtotime($b['created_at']) - strtotime($a['created_at']);
            });
    
            // The most recent reaction will now be the first element in the sorted array
            $mostRecentReaction = $userReactions[0];
    
            // Find the index of the most recent reaction in the original $reactions array
            $existingReactionKey = array_search($mostRecentReaction, $reactions);
    
            // Update the most recent reaction
            $reactions[$existingReactionKey]['emoji'] = $emoji; // Update the emoji
            $reactions[$existingReactionKey]['updated_at'] = now(); // Optionally, update the timestamp
        } else {
            // If no previous reaction, create a new reaction
            $newReaction = [
                'emoji' => $emoji,  // The emoji character (not the key)
                'employee_id' => Auth::user()->emp_id,  // The employee who reacted
                'created_at' => now(),  // Timestamp when the reaction was created
            ];
            $reactions[] = $newReaction; // Add the new reaction to the array
        }
    
        // Encode the reactions array back to JSON
        $reactionsJson = json_encode($reactions);
    
        // Update the kudo record with the new reactions JSON
        $kudo->update([
            'reactions' => $reactionsJson,
        ]);
    
        // Close the emoji picker after selection
        $this->showKudoEmojiPicker[$kudoId] = false;
        $this->mount();
    
        session()->flash('message', 'Reaction added/updated successfully!');
    }
    public function getReactionEmojis()
    {
        return $this->reactionEmojis;
    }
    public $reactionEmojis = [
        'thumbs_up' => '👍',
        'heart' => '❤️',
        'clap' => '👏',
        'laugh' => '😂',
        'surprised' => '😲',
        'sad' => '😢',
        'fire' => '🔥',
        'star' => '⭐',
        'party' => '🎉',
        'thinking' => '🤔',
        'love' => '😍',
        'happy' => '😀',
        'grin' => '😁',
        'joy' => '😂',
        'smile' => '😃',
        'big_smile' => '😄',
        'sweat_smile' => '😅',
        'laughing' => '😆',
        'angel' => '😇',
        'devil' => '😈',
        'wink' => '😉',
        'blush' => '😊',
        'tongue_out' => '😋',
        'in_love' => '😍',
        'relieved' => '😌',
        'cool' => '😎',
        'smirk' => '😏',
        'neutral' => '😐',
        'expressionless' => '😑',
        'unamused' => '😒',
        'pensive' => '😓',
        'disappointed' => '😔',
        'confused' => '😕',
        'confounded' => '😖',
        'kissing' => '😗',
        'blowing_kiss' => '😘',
        'kissing_heart' => '😙',
        'kissing_smiling_eyes' => '😚',
        'stuck_out_tongue' => '😛',
        'stuck_out_tongue_winking_eye' => '😜',
        'stuck_out_tongue_closed_eyes' => '😝',
        'disappointed_relieved' => '😞',
        'worried' => '😟',
        'angry' => '😠',
        'rage' => '😡',
        'cry' => '😢',
        'persevere' => '😣',
        'angry_face' => '😤',
        'disappointed_face' => '😥',
        'frowning' => '😦',
        'anguished' => '😧',
        'fearful' => '😨',
        'weary' => '😩',
        'sleepy' => '😪',
        'tired_face' => '😫',
        'grimacing' => '😬',
        'sob' => '😭',
        'astonished' => '😮',
        'hushed' => '😯',
        'open_mouth' => '😲',
        'flushed' => '😳',
        'sleeping' => '😴',
        'dizzy_face' => '😵',
        'face_without_mouth' => '😶',
        'mask' => '😷',
        'raised_hand' => '👋',
        'raised_back_of_hand' => '✋',
        'hand' => '🖐',
        'vulcan_salute' => '🖖',
        'raised_hand_with_fingers_splayed' => '🤚',
        'point_up' => '☝',
        'point_up_2' => '👆',
        'point_down' => '👇',
        'point_left' => '👈',
        'point_right' => '👉',
        'middle_finger' => '🖕',
        'fist_raised' => '✊',
        'fist' => '👊',
        'thumbs_up_reversed' => '👍',
        'victory_hand' => '✌',
        'ok_hand' => '👌',
        'pinching_hand' => '🤏',
    ];
    public function toggleKudosEmojiPicker($kudoId)
    {

        // Toggle the visibility of the emoji picker for the clicked kudo
        $this->mount();
        
        $this->showKudoEmojiPicker[$kudoId] = !$this->showKudoEmojiPicker[$kudoId];
       
    }
    public function mount()
    {

        $this->kudos  = Kudos::all();
      
        foreach ($this->kudos as $kudo) {
          
            $this->showKudoEmojiPicker[$kudo->id] = false; // Initially set to false
        }
        $user = Auth::user();
        $employeeId = Auth::guard('emp')->user()->emp_id;
        $employeeId = Auth::guard('emp')->user()->emp_id;

        if ($this->activeTab === 'Recieved') {
            // Fetch kudos where the logged-in user is the recipient
            $this->kudos = Kudos::join('employee_details as sender', 'kudos.employee_id', '=', 'sender.emp_id')
                ->join('employee_details as recipient', 'kudos.recipient_id', '=', 'recipient.emp_id')
                ->select(
                    'kudos.id',
                    'kudos.employee_id',
                    'kudos.recipient_id',
                    'kudos.message',
                    'kudos.recognize_type',
                    'kudos.reactions',
                    'kudos.post_type',
                    'kudos.created_at',
                    'kudos.updated_at',
                    'sender.first_name as sender_first_name',
                    'sender.last_name as sender_last_name',
                    'sender.gender as sender_gender',
                    'sender.email as sender_email',
                    'sender.emp_id as sender_emp_id',
                    'sender.image as sender_image',
                    'recipient.first_name as recipient_first_name',
                    'recipient.last_name as recipient_last_name',
                    'recipient.gender as recipient_gender',
                    'recipient.email as recipient_email',
                    'recipient.emp_id as recipient_emp_id',
                    'recipient.image as recipient_image'
                )
                ->where('kudos.recipient_id', $employeeId)
                ->orderBy('kudos.created_at', 'desc')
                ->get();
        } else {
            // Fetch kudos where the logged-in user is the sender
            $this->kudos = Kudos::join('employee_details as sender', 'kudos.employee_id', '=', 'sender.emp_id')
                ->join('employee_details as recipient', 'kudos.recipient_id', '=', 'recipient.emp_id')
                ->select(
                    'kudos.id',
                    'kudos.employee_id',
                    'kudos.recipient_id',
                    'kudos.message',
                    'kudos.reactions',
                    'kudos.recognize_type',
                    'kudos.post_type',
                    'kudos.created_at',
                    'kudos.updated_at',
                    'sender.first_name as sender_first_name',
                    'sender.last_name as sender_last_name',
                    'sender.gender as sender_gender',
                    'sender.email as sender_email',
                    'sender.emp_id as sender_emp_id',
                    'sender.image as sender_image',
                    'recipient.first_name as recipient_first_name',
                    'recipient.last_name as recipient_last_name',
                    'recipient.gender as recipient_gender',
                    'recipient.email as recipient_email',
                    'recipient.emp_id as recipient_emp_id',
                    'recipient.image as recipient_image'
                )
                ->where('kudos.employee_id', $employeeId)
                ->orderBy('kudos.created_at', 'desc')
                ->get();
        }
    }
    public function getRecognitionColor($recognizeType)
    {
        $colors = [
            'Approachable' => ['#fcead9', '#e67e22'], // Orange: light (#ff7f00), dark border/text (#e67e22)
            'Articulate' => ['#eaf5ec', '#298332'], // Green
            'Autonomous' => ['#c8daed', '#0056b3'], // Blue
            'Collaborator' => ['#eddfa9 ', '#f39c12'], // Yellow
            'Competitive' => ['#f0cdc9', '#c0392b'], // Red
            'Creative' => ['#dfc6ea', '#6c3483'], // Purple
            'Devoted' => ['#c8e8e1', '#1abc9c'], // Teal
            'Efficient' => ['#c2f2d6', '#27ae60'], // Light Green
            'Enthusiastic' => ['#f9edd9', '#e67e22'], // Amber
            'Independent' => ['#d3e4f0', '#2980b9'], // Light Blue
            'Innovator' => ['#ede2f1', '#8e44ad'], // Violet
            'Leader' => ['#dfeaf5', '#2c3e50'], // Dark Gray
            'Learner' => ['#dcf8f2', '#16a085'], // Turquoise
            'Motivator' => ['#f6ece5', '#e67e22'], // Orange
            'Open-minded' => ['#dfe6e6', '#7f8c8d'], // Gray
            'Opinionated' => ['#f5ebe2', '#d35400'], // Orange
            'Planning' => ['#e8f1f8', '#1f618d'], // Blue
            'Problem Solver' => ['#dae7f4', '#34495e'], // Dark Blue
            'Resourceful' => ['#dbf1ed', '#1abc9c'], // Teal
            'Strategist' => ['#ecd7f5', '#6c3483'], // Purple
            'Team Player' => ['#f6e5c9', '#e67e22'], // Amber
        ];

        // Return the background and border/text color based on the recognition type
        return $colors[$recognizeType] ?? ['#6c757d', '#5a6268']; // Default gray colors
    }
    public function showDropdown($kudoId)
    {

        $this->kudoId = $kudoId;
        $this->showOptions[$kudoId] = !($this->showOptions[$kudoId] ?? false);
        $this->mount();
    }
    public function render()
    {
        return view('livewire.kudos-history');
    }
}
