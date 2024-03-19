<div>
    <!DOCTYPE html>
    <html>

    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.3.1/jspdf.umd.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.2.3/html2canvas.min.js"></script>

    </head>

    <body>
        <div class="container-11" style="background-color: #02134F; color: white; padding: 8px;">
            <div style="display: flex; align-items: start; justify-content: start;">
                <img src="https://xsilica.com/images/xsilica_broucher_final_modified_05082016-2.png" alt="Logo" style="width: 200px; height: 50px; margin-right: 10px;">
                <h1 style="font-size: 21px; margin-left: 21%">Job Seeker - {{$user->full_name}}</h1>
                <div style="margin-left:25%">
                        <button class="logout" style="margin-top: 15px;text-align:end" wire:click="logout"> <i class="fas fa-sign-out-alt" style="margin-right: 5px;"></i> Logout</button>
                    </div>
            </div>
        </div>


        <div class="row-11" style="margin-left: 58%;margin-top:10px">
            <a href="/Jobs" style="text-decoration: none;">
                <button style="font-size:12px;width: 130px;height:30px; border-radius: 5px; margin: 0; background-color: rgb(2, 17, 79); color: white;margin-left: 5px;">
                    <i class="fas fa-briefcase" style="margin-right: 5px;"></i>
                    Jobs</button>
            </a>
            <a href="/Companies" style="text-decoration: none;">
                <button style="font-size:12px;width: 130px;height:30px; border-radius: 5px; margin: 0; background-color: rgb(2, 17, 79); color: white;margin-left: 5px;">
                    <i class="fas fa-building" style="margin-right: 5px;"></i>
                    Companies</button>
            </a>
            <a href="/AppliedJobs" style="text-decoration: none;">
                <button style="font-size:12px;width: 130px;height:30px; border-radius: 5px; margin: 0; background-color: rgb(2, 17, 79); color: white;margin-left: 5px;">
                    <i class="fas fa-check" style="margin-right: 5px;"></i> Applied Jobs</button>
            </a>
            <button style="font-size:12px;width: 100px; border-radius: 5px;height:30px; background-color: rgb(2, 17, 79); color: white;margin-left: 5px;">
                <a href="/UserProfile" style="text-decoration: none;color:white"> <i class="fa fa-user" style="margin-right: 5px;"></i> Profile</a>
            </button>
        </div>
        <div class="cv-container row m-0 mt-3">
            <div class="col-md-6" style="background-color: white; height: 230vh; overflow: auto;">
                <div style="text-align: center; margin-top: 20px; font-size: 24px;"><strong>Create CV</strong></div>
                <div class="row" style="padding: 15px; margin: 0px;">
                    <form wire.submit.prevent="submit" style="border: 1px solid rgb(2, 17, 79); background-color: rgb(2, 17, 79); height: 100%;width:100%; overflow: auto;padding:8px;">
                        <div style="text-align: center;">
                            <h2 style="color:white;font-size:13px;
            font-family: Montserrat;
                            ">Personal Information</h2>
                        </div>
                        <div class="education-entry">
                            <label style="font-size:12px" for="first_name">First Name:</label>
                            <input type="text" wire:model="first_name">
                            @error('first_name') <span class="error">{{ $message }}</span> @enderror <br>

                            <label style="font-size:12px" for="last_name">Last Name:</label>
                            <input type="text" wire:model="last_name">
                            @error('last_name') <span class="error">{{ $message }}</span> @enderror <br>

                            <label style="font-size:12px" for="email">Email:</label>
                            <input type="email" wire:model="email">
                            @error('email') <span class="error">{{ $message }}</span> @enderror <br>

                            <label style="font-size:12px" for="phone">Phone:</label>
                            <input type="tel" wire:model="phone">
                            @error('phone') <span class="error">{{ $message }}</span> @enderror <br>

                            <label style="font-size:12px" for="country">Country:</label>
                            <input type="text" wire:model="country">
                            @error('country') <span class="error">{{ $message }}</span> @enderror <br>

                            <label style="font-size:12px" for="city">City:</label>
                            <input type="text" wire:model="city">
                            @error('city') <span class="error">{{ $message }}</span> @enderror <br>

                            <label style="font-size:12px" for="address">Address:</label>
                            <input type="text" wire:model="address">
                            @error('address') <span class="error">{{ $message }}</span> @enderror <br>

                            <label style="font-size:12px" for="date_of_birth">Date of Birth:</label>
                            <input type="date" wire:model="date_of_birth" max="<?php echo date('Y-m-d'); ?>">
                            @error('date_of_birth') <span class="error">{{ $message }}</span> @enderror <br>

                            <label style="font-size:12px" for="image">Image:</label>
                            <input type="file" wire:model="image" accept="image/*">
                            @error('image') <span class="error">{{ $message }}</span> @enderror <br>
                            @if ($image)
                            <div>
                                <img style="height:90px;width:80px" src="{{ $image->temporaryUrl() }}" alt="Image Preview" style="max-width: 300px;">
                            </div>
                            @endif
                        </div>
                        <div style="text-align: center;">
                            <h2 style="color:white;font-size:13px;
            font-family: Montserrat;
                            ">Education</h2>
                        </div>
                        <!-- Education Entries -->
                        <div class="education-entries">
                            @foreach($educationEntries as $index => $educationEntry)
                            <div class="education-entry">
                                <label style="font-size:12px" for="degree">Degree:</label>
                                <input type="text" wire:model="educationEntries.{{ $index }}.degree" required><br>
                                @error("educationEntries.$index.degree") <span class="error">{{ $message }}</span>
                                @enderror <br>
                                <!-- Add similar error messages for other education fields -->
                                <label style="font-size:12px" for="university">University/Institution:</label>
                                <input type="text" wire:model="educationEntries.{{ $index }}.university" required><br>
                                @error("educationEntries.$index.university") <span class="error">{{ $message }}</span>
                                @enderror <br>
                                <label style="font-size:12px" for="graduation_year">Graduation Year:</label>
                                <input type="text" wire:model="educationEntries.{{ $index }}.graduation_year" required><br>
                                @error("educationEntries.$index.graduation_year") <span class="error">{{ $message }}</span> @enderror <br>
                                <button wire:click="removeEducation({{ $index }})" style="background-color:red;color:white;border-radius:5px;margin-bottom:8px" type="button" class="remove-education">Remove</button>
                            </div>
                            @endforeach

                        </div>

                        <!-- Add Education Entry button -->
                        <button wire:click="addEducation" id="add_education" style="background-color:green;color:white;border-radius:5px;margin-bottom:8px;margin-left:10px" type="button">Add</button>

                        <div style="text-align: center;">
                            <h2 style="color:white;font-size:13px;
            font-family: Montserrat;
                            ">Work Experience</h2>
                        </div>
                        <!-- Work Experience Entries -->
                        <div class="work-experience-entries">
                            @foreach($workExperienceEntries as $index => $workExperienceEntry)
                            <div class="work-experience-entry">
                                <label style="font-size:12px" for="job_title">Job Title:</label>
                                <input type="text" wire:model="workExperienceEntries.{{ $index }}.job_title" required><br>
                                @error("workExperienceEntries.$index.job_title") <span class="error">{{ $message }}</span> @enderror <br>
                                <!-- Add similar error messages for other work experience fields -->
                                <label style="font-size:12px" for="company">Company:</label>
                                <input type="text" wire:model="workExperienceEntries.{{ $index }}.company" required><br>
                                @error("workExperienceEntries.$index.company") <span class="error">{{ $message }}</span>
                                @enderror <br>
                                <label style="font-size:12px" for="start_date">Start Date:</label>
                                <input type="date" wire:model="workExperienceEntries.{{ $index }}.start_date" max="<?php echo date('Y-m-d'); ?>" required><br>
                                @error("workExperienceEntries.$index.start_date") <span class="error">{{ $message }}</span> @enderror <br>
                                <label style="font-size:12px" for="end_date">End Date:</label>
                                <input type="date" wire:model="workExperienceEntries.{{ $index }}.end_date" max="<?php echo date('Y-m-d'); ?>" required><br>
                                @error("workExperienceEntries.$index.end_date") <span class="error">{{ $message }}</span> @enderror <br>
                                <button wire:click="removeWorkExperience({{ $index }})" style="background-color:red;color:white;border-radius:5px;margin-bottom:8px" type="button" class="remove-work-experience">Remove</button>
                            </div>
                            @endforeach
                        </div>

                        <!-- Add Work Experience Entry button -->
                        <button wire:click="addWorkExperience" id="add_work_experience" style="margin-left:10px;background-color:green;color:white;border-radius:5px;margin-bottom:8px" type="button">Add</button>
                        <div style="text-align: center;">
                            <h2 style="color:white;font-size:13px;
            font-family: Montserrat;
                            ">Skills</h2>
                        </div>
                        <div class="education-entry">
                            <label style="font-size:12px" for="technical_skills">Technical Skills:</label>
                            <input type="text" wire:model="technical_skills">
                            @error('technical_skills') <span class="error">{{ $message }}</span> @enderror <br>
                        </div>
                        <div style="text-align: center;">
                            <h2 style="color:white;font-size:13px;">Professional Summary</h2>
                        </div>
                        <div class="education-entry">
                            <label style="font-size:12px" for="additional_info">Summary:</label>
                            <textarea wire:model="summary" rows="4"></textarea>
                            @error('summary') <span class="error">{{ $message }}</span> @enderror <br>
                        </div>
                        <div style="text-align: center;">
                            <h2 style="color:white;font-size:13px;">Languages</h2>
                        </div>
                        <div class="education-entry">
                            <label style="font-size:12px" for="languages">Languages and Proficiency:</label>
                            <input type="text" wire:model="languages">
                            @error('languages') <span class="error">{{ $message }}</span> @enderror <br>
                        </div>
                        <div class="row" style="margin-top: -15px; background-color: #f0f0f0; padding: 10px; border-top: 1px solid #ccc;">
                            <div class="col" style="margin-bottom: 10px;padding:5px">
                                <button type="button" wire:click="preview" style="background-color: #007BFF; color: #fff; padding: 10px 20px; border: none; border-radius: 5px;">Preview</button>
                            </div>
                            <div class="col" style="margin-bottom: 10px;padding:5px">
                                <button type="button" wire:click="submit" style="background-color: #28A745; color: #fff; padding: 10px 20px; border: none; border-radius: 5px;">Save</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="col-md-6" style="background-color: rgb(2, 17, 79);height: 230vh;overflow: auto;">

                <div id="card-content" style="margin-top: 15px;margin-bottom:15px;">
                    <!DOCTYPE html>
                    <html>

                    <head>
                        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
                        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
                        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

                    </head>

                    <body>
                        <div class="m-0 row" style="margin:0px !important">
                            <div class="col-md-6 p-0" style="padding:0px; color:#fff">
                                <div class="profile-image" style="padding: 10px; background-color: rgb(2, 17, 79)">
                                    @if($image)
                                    <img style="width: 130px;height:130px;border:5px solid white;" src="{{ $image->temporaryUrl() }}" alt="Your Photo">
                                    @else
                                    <div></div>
                                    @endif

                                </div>
                            </div>
                            <div class="col-md-6 p-0" style="background: #fff;height:160px; padding:0px">
                                <p class="name">{{$first_name}} {{$last_name}}</p>
                                @if(!empty($workExperienceEntries) && count($workExperienceEntries) > 0)
                                <p class="job-title">{{ $workExperienceEntries[0]['job_title'] }}</p>
                                @endif
                            </div>
                        </div>

                        <div class="cv-container row m-0">
                            <div class="col-md-6 p-0" style="background-color: #fff; padding:0px; height: 600px;">
                                <h6 style="text-align: center;font-size:12px;margin-top:10px;background-color:rgb(2, 17, 79);color:white;padding:5px;font-family: Montserrat;">
                                    <strong style="font-family: Montserrat;">PROFESSIONAL SUMMARY</strong>
                                </h6>
                                <p style="text-align:start;font-size: 13px;">
                                    {{$summary}}
                                </p>
                                <h6 style="text-align: center;font-size:12px;margin-top:10px;background-color:rgb(2, 17, 79);color:white;padding:5px">
                                    <strong style="font-family: Montserrat;">PERSONAL DETAILS</strong>
                                </h6>
                                <ul style="text-align: start;">
                                    @if($first_name &&$last_name)
                                    <li>
                                        <p style="font-size:12px"><strong>Name</strong> : {{$first_name}} {{$last_name}}
                                        </p>
                                    </li>
                                    @endif
                                    @if($email)
                                    <li>
                                        <p style="font-size:12px"><strong>Email</strong> : {{$email}}</p>
                                    </li>
                                    @endif
                                    @if($date_of_birth)
                                    <li>
                                        <p style="font-size:12px"><strong>DOB</strong> : {{$date_of_birth}}</p>
                                    </li>
                                    @endif
                                    @if($city && $address)
                                    <li>
                                        <p style="font-size:12px"><strong>Address</strong> : {{$city}},{{$address}}.</p>
                                    </li>
                                    @endif
                                </ul>
                                <h6 style="font-size:12px;text-align: center;background-color:rgb(2, 17, 79);color:white;margin-top:10px;padding:5px">
                                    <strong style="font-family: Montserrat;">LANGUAGES</strong>
                                </h6>
                                <ul>
                                    @if($languages)
                                    <li>
                                        <p style="font-size: 12px;">{{$languages}}</p>
                                    </li>
                                    @endif
                                </ul>
                            </div>
                            <div class="col-md-6 p-0" style="background-color: #f0f0f0;padding:0px; padding-left:4px !important;">

                                <h6 style="font-size:12px;text-align: center;margin-top:10px;background-color:rgb(2, 17, 79);color:white;padding:5px">
                                    <strong style="font-family: Montserrat;">TECHNICAL SKILLS</strong>
                                </h6>
                                <ul>
                                    @if($technical_skills)
                                    <li>
                                        <p style="font-size: 12px;">{{$technical_skills}}</p>
                                    </li>
                                    @endif
                                </ul>
                                <h6 style="font-size: 12px; text-align: center; background-color: rgb(2, 17, 79); color: white;padding:5px">
                                    <strong style="font-family: Montserrat;">EXPERIENCE</strong>
                                </h6>
                                <ul>
                                    @foreach($workExperienceEntries as $index => $workExperienceEntry)
                                    @if($workExperienceEntry['job_title'] && $workExperienceEntry['company'] &&
                                    $workExperienceEntry['start_date'] && $workExperienceEntry['end_date'])
                                    <li>
                                        <p>
                                        <div style="font-size: 12px">
                                            <strong>{{ $workExperienceEntry['job_title'] }}</strong>
                                        </div>
                                        <div style="font-size: 12px">{{ $workExperienceEntry['company'] }}</div>
                                        <div style="font-size: 12px">{{ $workExperienceEntry['start_date'] }} -
                                            {{ $workExperienceEntry['end_date'] }}
                                        </div>
                                        </p>
                                    </li>
                                    @endif
                                    @endforeach
                                </ul>

                                <h6 style="font-size: 12px; text-align: center; background-color: rgb(2, 17, 79); color: white;padding:5px">
                                    <strong style="font-family: Montserrat;">EDUCATION</strong>
                                </h6>
                                <ul>
                                    @foreach($educationEntries as $index => $educationEntry)
                                    @if($educationEntry['degree'] && $educationEntry['university'] &&
                                    $educationEntry['graduation_year'])
                                    <li>
                                        <p>
                                        <div style="font-size: 12px"><strong>{{ $educationEntry['degree'] }}</strong>
                                        </div>
                                        <div style="font-size: 12px">{{ $educationEntry['university'] }}</div>
                                        <div style="font-size: 12px">{{ $educationEntry['graduation_year'] }}</div>
                                        </p>
                                    </li>
                                    @endif
                                    @endforeach
                                </ul>

                            </div>
                        </div>
                    </body>

                    </html>
                </div>
                <div style="text-align: center;">
                    <button onclick="generatePDF()" class="btn btn-warning"> <a style="color: #fff; text-decoration: none;
            font-family: Montserrat;
                ">Download</a></button>
                </div>
            </div>
        </div>
    </body>


    </html>
</div>
<script>
    // JavaScript to handle adding and removing education and work experience entries

    document.addEventListener("livewire:load", function() {
        const addEducationButton = document.getElementById("add_education");
        const addWorkExperienceButton = document.getElementById("add_work_experience");

        // Event listener for adding education entry
        addEducationButton.addEventListener("click", function() {
            const educationContainer = document.querySelector(".education-entries");
            const index = document.querySelectorAll(".education-entry").length;
            educationContainer.appendChild(createEducationEntry(index));
        });

        // Event listener for adding work experience entry
        addWorkExperienceButton.addEventListener("click", function() {
            const workExperienceContainer = document.querySelector(".work-experience-entries");
            const index = document.querySelectorAll(".work-experience-entry").length;
            workExperienceContainer.appendChild(createWorkExperienceEntry(index));
        });

        // Event listener for removing education entry
        document.addEventListener("click", function(event) {
            if (event.target.classList.contains("remove-education")) {
                event.target.parentElement.remove();
            }
        });

        // Event listener for removing work experience entry
        document.addEventListener("click", function(event) {
            if (event.target.classList.contains("remove-work-experience")) {
                event.target.parentElement.remove();
            }
        });
    });

    // Function to create a new education entry
    function createEducationEntry(index) {
        const educationHTML = `
            <div class="education-entry">
                <label style="font-size:12px" for="degree">Degree:</label>
                <input type="text" wire:model="educationEntries.${index}.degree" required><br>
                <label style="font-size:12px" for="university">University/Institution:</label>
                <input type="text" wire:model="educationEntries.${index}.university" required><br>
                <label style="font-size:12px" for="graduation_year">Graduation Year:</label>
                <input type="text" wire:model="educationEntries.${index}.graduation_year" required><br>
                <button wire:click="removeEducation(${index})" style="background-color:red;color:white;border-radius:5px;margin-bottom:8px" type="button" class="remove-education">Remove</button>
            </div>
        `;
        const educationEntry = document.createElement("div");
        educationEntry.innerHTML = educationHTML;
        return educationEntry;
    }

    // Function to create a new work experience entry
    function createWorkExperienceEntry(index) {
        const workExperienceHTML = `
            <div class="work-experience-entry">
                <label style="font-size:12px" for="job_title">Job Title:</label>
                <input type="text" wire:model="workExperienceEntries.${index}.job_title" required><br>
                <label style="font-size:12px" for="company">Employer:</label>
                <input type="text" wire:model="workExperienceEntries.${index}.company" required><br>
                <label style="font-size:12px" for="start_date">Start Date:</label>
                <input type="date" wire:model="workExperienceEntries.${index}.start_date" max="<?php echo date('Y-m-d'); ?>" required><br>
                <label style="font-size:12px" for="end_date">End Date:</label>
                <input type="date" wire:model="workExperienceEntries.${index}.end_date" max="<?php echo date('Y-m-d'); ?>" required><br>
                <button wire:click="removeWorkExperience(${index})" style="background-color:red;color:white;border-radius:5px;margin-bottom:8px" type="button" class="remove-work-experience">Remove</button>
            </div>
        `;
        const workExperienceEntry = document.createElement("div");
        workExperienceEntry.innerHTML = workExperienceHTML;
        return workExperienceEntry;
    }

    function generatePDF() {
        // Create a Blob from the HTML content
        const cardContent = document.getElementById('card-content').innerHTML;
        const blob = new Blob([`<div style="max-width: 600px;margin:16px;">${cardContent}</div>`], {
            type: 'text/html'
        });

        // Add Bootstrap CDN links to the head of the HTML document
        const head = document.head;
        // const body = document.body;

        // Bootstrap CSS link
        const bootstrapCssLink = document.createElement('link');
        bootstrapCssLink.rel = 'stylesheet';
        bootstrapCssLink.href = 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css';
        bootstrapCssLink.integrity = 'sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN';
        bootstrapCssLink.crossorigin = 'anonymous';
        document.head.appendChild(bootstrapCssLink);

        // Bootstrap JS script
        const bootstrapJsScript = document.createElement('script');
        bootstrapJsScript.src = 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js';
        bootstrapJsScript.integrity = 'sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL';
        bootstrapJsScript.crossOrigin = 'anonymous';
        document.head.appendChild(bootstrapJsScript);

        // Create a URL for the Blob
        const url = URL.createObjectURL(blob);

        // Create an <a> element for downloading the PDF
        const a = document.createElement('a');
        a.href = url;
        a.download = 'cv.html'; // Specify the filename with .html extension
        a.style.display = 'none';

        // Append the <a> element to the document and trigger the download
        document.body.appendChild(a);
        a.click();

        // Clean up by revoking the object URL
        window.URL.revokeObjectURL(url);


    }
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>