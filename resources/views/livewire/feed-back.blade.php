<div class="bg-white">
    <div class="text-end pt-3">
        <button class="btn btn-primary me-3" data-bs-toggle="modal" data-bs-target="#requestFeedbackModal">Request Feedback</button>
        <button class="btn btn-primary me-3" data-bs-toggle="modal" data-bs-target="#requestFeedbackModal">Give Feedback</button>
    </div>

    <ul class="nav nav-tabs" id="myTab" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="recieved-tab" data-bs-toggle="tab" data-bs-target="#recieved-tab-pane" type="button" role="tab" aria-controls="recieved-tab-pane" aria-selected="true">Recieved</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="given-tab" data-bs-toggle="tab" data-bs-target="#given-tab-pane" type="button" role="tab" aria-controls="given-tab-pane" aria-selected="false">Given</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="pending-tab" data-bs-toggle="tab" data-bs-target="#pending-tab-pane" type="button" role="tab" aria-controls="pending-tab-pane" aria-selected="false">Pending Request</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="drafts-tab" data-bs-toggle="tab" data-bs-target="#drafts-tab-pane" type="button" role="tab" aria-controls="drafts-tab-pane" aria-selected="false">Drafts</button>
        </li>
    </ul>
    <div class="tab-content pb-5" id="myTabContent">
        <div class="tab-pane fade show active" id="recieved-tab-pane" role="tabpanel" aria-labelledby="recieved-tab" tabindex="0">
            <div class="m-0 pt-4 row text-center">
                <img src="images/recieved-feed.png" class="m-auto" style="width: 10em" />
                <h5>Seeking Advice?</h5>
                <p>Let's gather a new outlook from ypur coworkers</p>
                <div >
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#requestFeedbackModal">Request Feedback</button>
                </div>
            </div>
        </div>
        <div class="tab-pane fade" id="given-tab-pane" role="tabpanel" aria-labelledby="given-tab" tabindex="0">
            <div class="m-0 pt-4 row text-center">
                <img src="images/given.png" class="m-auto" style="width: 10em" />
                <h5>Seeking Advice?</h5>
                <p>Let's gather a new outlook from ypur coworkers</p>
                <div >
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#requestFeedbackModal">Give Feedback</button>
                </div>
            </div>
        </div>
        <div class="tab-pane fade" id="pending-tab-pane" role="tabpanel" aria-labelledby="pending-tab" tabindex="0">
            <div class="m-0 pt-4 row text-center">
                <img src="images/pending-request.png" class="m-auto" style="width: 10em" />
                <h5>See feedback requests and responses here</h5>
                <p>Your requests and feedback requests from peers will appear here. Once feedback is shared, it will moved to recived or given sections</p>
                <div >
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#requestFeedbackModal">Request Feedback</button>
                </div>
            </div>
        </div>
        <div class="tab-pane fade" id="drafts-tab-pane" role="tabpanel" aria-labelledby="drafts-tab" tabindex="0">
            <div class="m-0 pt-4 row text-center">
                <img src="images/drafts.png" class="m-auto" style="width: 10em" />
                <h5>Draft your feedback</h5>
                <p>Capture your thoughts on feedback and find it later</p>
                <div >
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#requestFeedbackModal">Give Feedback</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="requestFeedbackModal" tabindex="-1" aria-labelledby="requestFeedbackModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
            <h1 class="modal-title fs-5" id="requestFeedbackModalLabel">Request Feedback</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <form>
                <div class="mb-3">
                    <label for="exampleInputEmail1" class="form-label">Search Employee <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
                </div>
                <div class="mb-3">
                    <label for="exampleInputPassword1" class="form-label">Include a personalised message <span class="text-danger">*</span></label>
                    <div id="editor"></div>
                </div>

                
            </form>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary">Save changes</button>
        </div>
        </div>
    </div>
    </div>
</div>

