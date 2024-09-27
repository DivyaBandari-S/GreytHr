<?php

namespace App\Livewire;

use App\Models\Company;
use App\Models\Post;
use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\EmployeeDetails;
use App\Models\Hr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
class Everyone extends Component
{
    
    use WithFileUploads;

    public $image;
    public $posts;

    public $showAlert = false;
    public $file_path;

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
    public function addFeeds()
    {
        $this->showFeedsDialog = true;
    }
    public function openPost($postId)
    {
        $post = Post::find($postId);
    
        if ($post) {
            $post->update(['status' => 'Open']);
        }
    
        return redirect()->to('/feeds'); // Redirect to the appropriate route
    }
    
    public function mount()
    {
     
        $this->posts  = Post::where('status', 'Closed')
             ->orderBy('updated_at', 'desc')
             ->get();

        $this->empCompanyLogoUrl = $this->getEmpCompanyLogoUrl();
  
        $user = Auth::user();

        if ($user) {
            $this->employeeDetails = $user->employeeDetails;
        }
        $employeeId = Auth::guard('emp')->user()->emp_id;
        $this->isManager = DB::table('employee_details')
            ->where('manager_id', $employeeId)
            ->exists();
       
                // Fetch posts for the manager and their employees
          
                    if ($this->isManager) {
                    // For managers: get their posts and their team's posts
                    $this->posts = Post::where('status', 'Closed')
                        ->where(function ($query) use ($employeeId) {
                            $query->where('manager_id', $employeeId) // Manager's own posts
                                  ->orWhereIn('emp_id', function ($subQuery) use ($employeeId) {
                                      $subQuery->select('emp_id')
                                                ->from('employee_details')
                                                ->where('manager_id', $employeeId); // Team members' posts
                                  });
                        })
                        ->orderBy('updated_at', 'desc')
                        ->get();
                } else {
                    // For employees: get their posts and their manager's posts
                    $this->posts = Post::where('status', 'Closed')
                    ->where(function ($query) use ($employeeId) {
                        $query->where('emp_id', $employeeId) // Employee's own posts
                              ->orWhere('manager_id', function($subQuery) use ($employeeId) {
                                  $subQuery->select('manager_id')
                                            ->from('employee_details')
                                            ->where('emp_id', $employeeId); // Get the employee's manager's ID
                              })
                              ->orWhereIn('emp_id', function($subQuery) use ($employeeId) {
                                  // Get all employees under the same manager
                                  $subQuery->select('emp_id')
                                            ->from('employee_details')
                                            ->where('manager_id', function($innerQuery) use ($employeeId) {
                                                $innerQuery->select('manager_id')
                                                            ->from('employee_details')
                                                            ->where('emp_id', $employeeId);
                                            });
                              });
                    })
                    ->orderBy('updated_at', 'desc')
                    ->get();
                
                }
            
        
    
                // Debugging to check the retrieved posts
               
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
        // Update validation to only allow image files
        $validatedData = $this->validate([
            'category' => 'required|string|max:255',
            'description' => 'required|string',
            'file_path' => 'nullable|file|mimes:jpeg,png,jpg,gif,svg|max:2048', // Only allow image files with a max size of 2MB
        ]);
    
        try {
            $fileContent = null;
            $mimeType = null;
            $fileName = null;
    
            // Process the uploaded image file
            if ($this->file_path) {
                // Validate file is an image
                if (!in_array($this->file_path->getMimeType(), ['image/jpeg', 'image/png', 'image/gif', 'image/svg+xml'])) {
                    session()->flash('error', 'Only image files (jpeg, png, gif, svg) are allowed.');
                    return;
                }
    
                $fileContent = file_get_contents($this->file_path->getRealPath());
                $mimeType = $this->file_path->getMimeType();
                $fileName = $this->file_path->getClientOriginalName();
            }
    
            // Check if the file content is valid
            if ($fileContent === false) {
                Log::error('Failed to read the uploaded file.', [
                    'file_path' => $this->file_path->getRealPath(),
                ]);
                session()->flash('error', 'Failed to read the uploaded file.');
                return;
            }
    
            // Check if the file content is too large (16MB limit for MEDIUMBLOB)
            if (strlen($fileContent) > 16777215) {
                session()->flash('error', 'File size exceeds the allowed limit.');
                return;
            }
    
            // Get the authenticated user
            $user = Auth::user();
    
            // Get the authenticated employee ID and their details
            $employeeId = auth()->guard('emp')->user()->emp_id;
            $employeeDetails = EmployeeDetails::where('emp_id', $employeeId)->first();
    
            // Check if the authenticated employee is a manager
            $isManager = DB::table('employee_details')
                ->where('manager_id', $employeeId)
                ->exists();
    
            // If not a manager, set `emp_id` instead of `manager_id`
            $postStatus = $isManager ? 'Closed' : 'Pending'; // Set to 'Closed' if the user is a manager
            $managerId = $isManager ? $employeeId : null;
            $empId = $isManager ? null : $employeeId;
    
            // Retrieve the HR details if applicable
            $hrDetails = Hr::where('hr_emp_id', $user->hr_emp_id)->first();
    
            // Create the post
            $post = Post::create([
                'hr_emp_id' => $hrDetails->hr_emp_id ?? '-',
                'manager_id' => $managerId, // Set manager_id only if the user is a manager
                'emp_id' => $empId,          // Set emp_id only if the user is an employee
                'category' => $this->category,
                'description' => $this->description,
                'file_path' => $fileContent, // Store binary data in the database
                'mime_type' => $mimeType,
                'file_name' => $fileName,
                'status' => $postStatus,
            ]);
    
            // Reset form fields and display success message
            $this->reset(['category', 'description', 'file_path']);
            session()->flash('message', 'Post created successfully!');
            $this->showFeedsDialog = false;
    
        } catch (\Illuminate\Validation\ValidationException $e) {
            $this->setErrorBag($e->validator->getMessageBag());
        } catch (\Exception $e) {
            Log::error('Error creating request: ' . $e->getMessage(), [
                'employee_id' => $employeeId ?? 'N/A',
                'file_path_length' => isset($fileContent) ? strlen($fileContent) : null,
            ]);
            session()->flash('error', 'An error occurred while creating the request. Please try again.');
        }
    }
    
    

    public function render()
    {

          if (auth()->guard('hr')->check()) {
            $this->employeeDetails = Hr::where('hr_emp_id', Auth::user()->hr_emp_id)->first();
        } elseif (auth()->guard('emp')->check()) {
            $this->employeeDetails = EmployeeDetails::where('emp_id', Auth::user()->emp_id)->first();
        } else {
            // Handle case where no guard is matched
            Session::flash('error', 'User is not authenticated as HR or Employee');
            return;
        }
        
        return view('livewire.everyone',[     'empCompanyLogoUrl' => $this->empCompanyLogoUrl,     ]);
    }
}
