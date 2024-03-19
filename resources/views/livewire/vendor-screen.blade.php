<div>
 
    <div class="container-11" style="background-color: #02134F; color: white; padding:2px;height:53px">

        <div style="display: flex; align-items: start; justify-content: start;">
        <img src="https://xsilica.com/images/xsilica_broucher_final_modified_05082016-2.png" alt="Logo" style="height: 50px; margin-right: 10px;">

            <h1 style="font-size: 20px; margin-left:23%">Vendor - {{$user->full_name}}</h1>
            <div style="margin-left:25%;">
                <button style="margin-bottom: 10px;" class="logout" style="text-align:end" wire:click="logout"> <i class="fas fa-sign-out-alt"></i> Logout</button>
            </div>
        </div>

    </div>
    <div class="container">
        <h2 style="text-align: center;
            font-family: Montserrat;
            ">All Jobs List</h2>
        @if($showSuccessMessage)
        <div class="alert alert-success" id="success-message">
            Your job application has been submitted successfully!
            <button class="close-message" wire:click="dismissMessage">×</button>
        </div>
        @elseif ($errors->has('duplicate'))
        <div class="alert alert-danger" id="error-message">
            {{ $errors->first('duplicate') }}
            <button class="close" wire:click="dismissError">×</button>
        </div>
        @endif
        @if (!is_null($jobs) && $jobs->count() > 0)

        <div class="job-listings" style="padding: 5px;">
            @foreach ($jobs as $index => $job)
            <div class="job-card" style="text-align: start;">
                <h3 class="job-title">{{ $job->title }}</h3>
                <p class="job-company"><strong class="subtitle">{{ $job->company_name }}</strong></p>

                <div>
                    <table>
                        <tr>
                            <th style="font-size: 12px; text-align: start;">
                                <p class="job-location" style="width: 150px;">
                                    <i class="fas fa-map-marker-alt"></i> {{ $job->location }}
                                </p>
                            </th>
                            <th style="font-size: 12px; text-align: start;">
                                <p class="job-salary" style="width:250px">
                                    <strong style="margin-right: 10px;">₹</strong>{{ number_format($job->salary, 2) }}
                                    PA
                                </p>
                            </th>
                            <th style="font-size: 12px; text-align: start;">
                                <p class="job-posted-at" style="width:150px">
                                    <i class="far fa-calendar-alt"></i>
                                    {{ date('d M Y', strtotime($job->expire_date)) }}
                                    <strong style="font-size: 10px;">(Expired)</strong>
                                </p>
                            </th>
                        </tr>
                    </table>
                </div>

                <table>
                    <tr>
                        <th style="font-size: 12px; text-align: start;">
                            <p class="job-vacancies" style="width:150px">
                                <i class="fas fa-users"></i> Vacancies: {{ $job->vacancies }}
                            </p>
                        </th>
                        <th style="font-size: 12px; text-align: start;">
                            <p class="job-education-requirement" style="width:250px;margin-right: 10px;">
                                <i class="fas fa-graduation-cap"></i> Education: {{ $job->education_requirement }}
                            </p>
                        </th>
                        <th style="font-size: 12px; text-align: start;">
                            <p class="job-experience-requirement" style="width:150px;">
                                <i class="fas fa-briefcase"></i> Experience: {{ $job->experience_requirement }}
                            </p>
                        </th>
                    </tr>
                </table>

                <p class="job-skills-required">
                    <i class="fas fa-tools"></i> Skills: {{ $job->skills_required }}
                </p>


                <div style="text-align: center;">
                    <table>
                        <tr>
                            <th style="width: 210px;">
                                <div class="pdf-preview-grid" id="pdf-preview{{ $index }}" style="text-align: center; display: none;">
                                    <iframe class="pdf-iframe" id="pdfIframe{{ $index }}" style="border: none;"></iframe>
                                </div>
                            </th>
                            <th>
                                <label for="cv{{ $index }}" style="font-size: 10px; display: inline-block; margin-right: 10px;">Select CV's</label>
                                <input wire:model="cv.{{ $job->job_id }}" type="file" id="cv{{ $index }}" accept=".pdf" style="display: none;" multiple onchange="previewPDFs(event, {{ $index }})">
                            </th>
                            <th>
                                <a wire:click="submitJobApplication('{{ $job->job_id }}')" class="apply-button" style="display: inline-block; font-size: 10px" wire:loading.attr="disabled">Submit</a>
                            </th>

                        </tr>
                    </table>
                </div>

                @if($errors->has("cv.$job->job_id"))
                <span style="text-align:center;display:flex;justify-content:center;color:red;font-size: 12px" class="error">
                    {{ $errors->first("cv.$job->job_id") }}
                </span>
                @enderror



                <div class="cv-info-container">
                    <div class="cv-info">
                        <p>Total CVs Submitted for this job: <span class="cv-count">{{ $cvCounts[$job->job_id] }}</span></p>
                    </div>
                    <div class="cv-info">
                        <p>Your Submissions for this job: <span class="cv-count">{{ $cvCountsForVendor[$job->job_id] }}</span></p>
                    </div>
                </div>


            </div>
            @endforeach

        </div>
        @else
        <div style="text-align:center;margin-top:10px">No Jobs Found</div>
        @endif
    </div>
</div>


<script>
    function previewPDFs(event, index) {
        const pdfPreviewContainer = document.getElementById('pdf-preview' + index);
        pdfPreviewContainer.style.display = 'block';

        const selectedFiles = event.target.files;

        // Clear the previous previews
        pdfPreviewContainer.innerHTML = '';

        if (selectedFiles.length > 0) {
            for (const file of selectedFiles) {
                if (file.type === 'application/pdf') {
                    if (file.size > 1024 * 1024) {
                        const errorMessage = document.createElement('p');
                        errorMessage.textContent = 'File size exceeds 1MB: ' + file.name;
                        errorMessage.style.color = 'red'; // Set the color to red
                        errorMessage.style.fontSize = '14px';
                        pdfPreviewContainer.appendChild(errorMessage);
                    } else {
                        const fileURL = URL.createObjectURL(file);
                        const iframe = document.createElement('iframe');
                        iframe.src = fileURL;
                        iframe.width = 50; // Adjust the width as needed
                        iframe.height = 30; // Adjust the height as needed
                        iframe.style.border = 'none';
                        pdfPreviewContainer.appendChild(iframe);
                    }
                } else {
                    const errorMessage = document.createElement('p');
                    errorMessage.textContent = 'File is not a PDF: ' + file.name;
                    pdfPreviewContainer.appendChild(errorMessage);
                }
            }
        } else {
            pdfPreviewContainer.style.display = 'none';
        }
    }
</script>