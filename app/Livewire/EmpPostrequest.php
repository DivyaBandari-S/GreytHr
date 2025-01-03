<?php

namespace App\Livewire;

use App\Helpers\FlashMessageHelper;
use Livewire\Component;
use App\Models\Company;
use App\Models\Post;

use Livewire\WithFileUploads;
use App\Models\EmployeeDetails;
use App\Models\Hr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
class EmpPostrequest extends Component
{  use WithFileUploads;

    public $image;
    public $posts;
    public $showImageDialog = false;
    public $newCommentRules;

    public $showAlert = false;
    public $file_path;
    public $imageUrl;

    public $category;
    public $isManager;
    public $employeeId;
    public $description;
    public $attachment;
    public $employeeDetails;
    public $message = '';
    public $showFeedsDialog = false;
    public $empCompanyLogoUrl;

    protected $rules = [
        'category' => 'required',
        'description' => 'required',
        'attachment' => 'nullable|file|max:10240',
    ];
    protected $messages = [
        'category.required' => 'Category is required.',
  
        'description.required' => 'Description is required.',
       
    ];
    public function closePost($postId)
    {
        $post = Post::find($postId);
    
        if ($post && $post->status !== 'a') {
            $post->status = 'Closed';
            $success = $post->save(); // Save and check if successful
    
            if ($success) {
                // Set the flash message only if the status was successfully updated
                FlashMessageHelper::flashSuccess('Request approved.');
            }
            return redirect()->to('/everyone');
        }
    } 
    public function rejectPost($postId)
    {
        $post = Post::find($postId);
    
        if ($post && $post->status !== 'b') {
            $post->status = 'Rejected';
            $success = $post->save(); // Save and check if successful
    
            if ($success) {
                // Set the flash message only if the status was successfully updated
                FlashMessageHelper::flashError( 'Request Rejected.');
            }
            return redirect()->to('/emp-post-requests');
        }
    } 
    public function downloadImage()
    {
        if ($this->imageUrl) {
            // Decode the Base64 data if necessary
            $fileData = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $this->imageUrl));

            // Determine MIME type and file extension
            $finfo = finfo_open(FILEINFO_MIME_TYPE);
            $mimeType = finfo_buffer($finfo, $fileData);
            finfo_close($finfo);

            $extension = '';
            switch ($mimeType) {
                case 'image/jpeg':
                    $extension = 'jpg';
                    break;
                case 'image/png':
                    $extension = 'png';
                    break;
                case 'image/gif':
                    $extension = 'gif';
                    break;
                default:
                    return abort(415, 'Unsupported Media Type');
            }

            // Prepare file name and response
            $fileName = 'image-' . time() . '.' . $extension;
            return response()->streamDownload(
                function () use ($fileData) {
                    echo $fileData;
                },
                $fileName,
                [
                    'Content-Type' => $mimeType,
                    'Content-Disposition' => 'attachment; filename="' . $fileName . '"',
                ]
            );
        }
        return abort(404, 'Image not found');
    }

    public function handleRadioChange($value)
    {
        // Define the URLs based on the radio button value
        $urls = [
            'posts' => '/everyone',
            'activities' => '/Feeds',
            'post-requests'=>'/emp-post-requests'
            // Add more mappings if necessary
        ];
    
        // Redirect to the correct URL
        if (array_key_exists($value, $urls)) {
            return redirect()->to($urls[$value]);
        }
    }
    
    public function addFeeds()
    {
        $this->showFeedsDialog = true;
    }
    public function mount()
    {
        // Retrieve posts data and assign it to the $posts property
        $this->posts = Post::orderBy('created_at', 'desc')->get();
        $this->empCompanyLogoUrl = $this->getEmpCompanyLogoUrl();
  
        $user = Auth::user();
        $this->employeeDetails = $user->employeeDetails;

        if ($user) {
            $this->employeeDetails = $user->employeeDetails;
        }
        $employeeId = Auth::guard('emp')->user()->emp_id;
        $this->isManager = DB::table('employee_details')
        ->where('manager_id', $employeeId)
        ->exists();
    }
    private function getEmpCompanyLogoUrl()
    {
        // Get the current authenticated employee's company ID
        if (auth()->guard('emp')->check()) {
            // Get the current authenticated employee's company ID
            $empCompanyId = auth()->guard('emp')->user()->company_id;
    
            // Assuming you have a Company model with a 'company_logo' attribute
            $company = Company::where('company_id', $empCompanyId)->first();
    
            // Return the company logo URL, or a default if company not found
            return $company ? $company->company_logo : asset('user.jpg');
        } elseif (auth()->guard('hr')->check()) {
            $empCompanyId = auth()->guard('hr')->user()->company_id;
    
            // Assuming you have a Company model with a 'company_logo' attribute
            $company = Company::where('company_id', $empCompanyId)->first();
            return $company ? $company->company_logo : asset('user.jpg');
        }
    

        
      
    }
    
    public function showImage($url)
    {
        $this->imageUrl = $url;
        $this->showImageDialog = true;
    }
    public function closeImageDialog()
    {
        $this->showImageDialog = false;
    }
    public function closeFeeds()
    {
        
        $this->message = '';
        $this->showFeedsDialog = false;
        $this->resetErrorBag(); // Reset validation errors if any
        $this->resetValidation(); // Reset validation state
        $this->reset(['category', 'description', 'attachment', 'message', 'showFeedsDialog']);
    }

    public function upload()
    {
        $this->validate([
            'attachment' => 'required|file|max:10240',
        ]);

        $this->attachment->store('attachments');
        $this->message = 'File uploaded successfully!';
    }


    public function submit()
    {
        $validatedData = $this->validate([
            'category' => 'required|string|max:255',
            'description' => 'required|string',
            'file_path' => 'nullable|file|mimes:jpeg,png,jpg,gif,svg|max:2048', // Only allow image files
        ]);
    
        try {
            $fileContent = null;
            $mimeType = null;
            $fileName = null;
    
            if ($this->file_path) {
                if (!in_array($this->file_path->getMimeType(), ['image/jpeg', 'image/png', 'image/gif', 'image/svg+xml'])) {
                    session()->flash('error', 'Only image files (jpeg, png, gif, svg) are allowed.');
                    return;
                }
    
                $fileContent = file_get_contents($this->file_path->getRealPath());
                $mimeType = $this->file_path->getMimeType();
                $fileName = $this->file_path->getClientOriginalName();
    
                if ($fileContent === false || strlen($fileContent) > 16777215) {
                    FlashMessageHelper::flashWarning('File size exceeds the allowed limit or could not be read.');
                    return;
                }
            }
    
            $user = Auth::user();
            $employeeId = auth()->guard('emp')->user()->emp_id;
            $employeeDetails = EmployeeDetails::where('emp_id', $employeeId)->first();
             // Fetch the manager_id of the current employee
             $managerId = $employeeDetails->manager_id;
    
             if (!$managerId) {
                 FlashMessageHelper::flashError('Manager information not found for the current employee.');
                 return;
             }
     
             // Check if the authenticated employee is a manager
             $isManager = DB::table('employee_details')
                 ->where('manager_id', $employeeId)
                 ->exists();
     
             $postStatus = $isManager ? 'Closed' : 'Pending';
             $managerId = $isManager ? $employeeId : null;
             $empId = $isManager ? null : $employeeId;
    
           
    
            $hrDetails = Hr::where('hr_emp_id', $user->hr_emp_id)->first();
    
            $post = Post::create([
                'hr_emp_id' => $hrDetails->hr_emp_id ?? '-',
                'manager_id' => $managerId,
                'emp_id' => $empId,
                'category' => $this->category,
                'description' => $this->description,
                'file_path' => $fileContent,
                'mime_type' => $mimeType,
                'file_name' => $fileName,
                'status' => $postStatus,
            ]);
    
            // Send email notification to manager
            $managerDetails = EmployeeDetails::where('emp_id', $employeeDetails->manager_id)->first();
            if ($managerDetails && $managerDetails->email) {
                $managerName = $managerDetails->first_name . ' ' . $managerDetails->last_name;
               
                Mail::to($managerDetails->email)->send(new PostCreatedNotification($post, $employeeDetails,$managerName));
            }
           // Optionally, send email to HR
            if ($hrDetails && $hrDetails->email) {
                $managerName = $managerDetails->first_name . ' ' . $managerDetails->last_name;
                Mail::to($hrDetails->email)->send(new PostCreatedNotification($post, $employeeDetails,$managerName));
            }
    
    
            // Reset form fields and redirect to posts page
            $this->reset(['category', 'description', 'file_path']);
            FlashMessageHelper::flashSuccess('Post created successfully!');
             // Update 'manager.posts' to the actual route name for the posts page
    
        } catch (\Illuminate\Validation\ValidationException $e) {
            $this->setErrorBag($e->validator->getMessageBag());
        } catch (\Exception $e) {
            Log::error('Error creating post: ' . $e->getMessage(), [
                'employee_id' => $employeeId ?? 'N/A',
                'file_path_length' => isset($fileContent) ? strlen($fileContent) : null,
            ]);
            FlashMessageHelper::flashError('An error occurred while creating the post. Please try again.');
        }
    }
    
    
    
    

    public function render()
    {

        $this->employeeDetails = EmployeeDetails::where('emp_id', Auth::user()->emp_id)->first();

          if (auth()->guard('hr')->check()) {
            $this->employeeDetails = Hr::where('hr_emp_id', Auth::user()->hr_emp_id)->first();
        } elseif (auth()->guard('emp')->check()) {
            $this->employeeDetails = EmployeeDetails::where('emp_id', Auth::user()->emp_id)->first();
        } else {
            // Handle case where no guard is matched
            Session::flash('error', 'User is not authenticated as HR or Employee');
            return;
        }
        
        return view('livewire.emp-postrequest',[     'employees' => $this->employeeDetails,    'empCompanyLogoUrl' => $this->empCompanyLogoUrl,     'isManager' => $this->isManager,]);
    }
}
