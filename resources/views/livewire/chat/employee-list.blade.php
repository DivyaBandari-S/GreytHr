<div class="container-fluid my-1" id='chartScreen'>
  

    <div class="wrapper-canvas bg-white">
        <div class="sidebar">
            <!-- <a class="logo">
                <img src="images/images/logo.svg" alt="">
            </a> -->
            <div class="menus">
                <a href="#">
                    <span class="material-icons">
                        home
                    </span>
                </a>
                <a href="#">
                    <span class="material-icons">
                        question_answer
                    </span>
                    <!-- <span class="dot"></span> -->
                </a>
                <a href="#">
                    <span class="material-icons">
                        call
                    </span>
                    <!-- <span class="dot"></span> -->
                </a>
                <!-- <a href="#">
                    <span class="material-icons">
                        devices
                    </span> -->

                    <span class="dot"></span>
                </a>
                <a id="people-link" href="#" class="active" onclick="openPeopleList()">
                    <span class="material-icons">
                        people
                    </span>


                    <!-- <span class="dot"></span> -->
                </a>
                <!-- <a href="#">
                    <span class="material-icons">
                        open_in_browser
                    </span>


                    <span class="dot"></span>
                </a> -->
                <a href="#">
                    <span class="material-icons">
                        event_note
                    </span>


                    <!-- <span class="dot"></span> -->
                </a>
                <a id="settings-link" href="#" onclick="openSetting()">
                    <span class="material-icons">
                        settings
                    </span>


                    <!-- <span class="dot"></span> -->
                </a>
            </div>
        </div>

            <div class="sidebar-list-contacts" id="contacts">
                <div class="top">
                    <a href="/">
                        <div class="nav-toggle btn">
                            <span class="material-icons">
                                keyboard_backspace
                            </span>
                        
                        </div>
                    </a>
                    <div class="title">Contacts</div>
                    <!-- <div class="navigation">
                        <a href="#" class="btn prev">
                            <span class="material-icons">
                                chevron_left
                            </span>
                        </a>
                        <a href="#" class="btn next">
                            <span class="material-icons">
                                chevron_right
                            </span>
                        </a>
                    </div> -->
                </div>
                <div class="body">
                    <!-- <div class="search">
                        <div class="label-text">Search for a contact</div>
                        <div class="input-search">
                            <input type="text" class="form-control" placeholder="Name, email or phone number">
                            <button class="btn-search">
                                <span class="material-icons">
                                    search
                                </span>
                            </button>
                        </div>
                    </div> -->
                    <div class="input-group mb-3">
                        <span class="input-group-text bg-white pe-0" id="basic-addon1"><i class="fa-solid fa-magnifying-glass"></i></span>
                        <input type="text" class="contSearch form-control" placeholder="Search for a name, email or phone number" aria-label="Username" aria-describedby="basic-addon1">
                    </div>
                    <div class="list-users">
                        <div class="item active">
                            <div class="avatar-chart">
                                <img src="images/images/avatarr-default.jpeg" alt="">
                                <span class="dot -online"></span>
                            </div>
                            <div class="text-content">
                                <div class="name">Nicholas Gordon</div>
                                <div class="pos">Developer</div>
                            </div>
                            <div class="actions">
                                <button class="btn" onclick="openMsgDiv()">
                                    <span class="material-icons position-relative">
                                        question_answer
                                        <span class="msgCount badge rounded-pill text-bg-danger">9</span>
                                    </span>

                                </button>
                                <!-- <button class="btn">
                                    <span class="material-icons">
                                        phone
                                    </span>

                                </button>
                                <button class="btn">
                                    <span class="material-icons">
                                        more_horiz
                                    </span>
                                </button> -->
                            </div>
                        </div>
                        <div class="item">
                            <div class="avatar-chart">
                                <img src="images/images/avatarr-default.jpeg" alt="">
                                <span class="dot -online"></span>
                            </div>
                            <div class="text-content">
                                <div class="name">Nicholas Gordon</div>
                                <div class="pos">Developer</div>
                            </div>
                            <div class="actions">
                                <button class="btn">
                                    <span class="material-icons">
                                        question_answer
                                    </span>

                                </button>
                                <!-- <button class="btn">
                                    <span class="material-icons">
                                        phone
                                    </span>

                                </button>
                                <button class="btn">
                                    <span class="material-icons">
                                        more_horiz
                                    </span>
                                </button> -->
                            </div>
                        </div>
                        <div class="item">
                            <div class="avatar-chart">
                                <img src="images/images/avatarr-default.jpeg" alt="">
                                <span class="dot -online"></span>
                            </div>
                            <div class="text-content">
                                <div class="name">Nicholas Gordon</div>
                                <div class="pos">Developer</div>
                            </div>
                            <div class="actions">
                                <button class="btn">
                                    <span class="material-icons">
                                        question_answer
                                    </span>

                                </button>
                                <!-- <button class="btn">
                                    <span class="material-icons">
                                        phone
                                    </span>

                                </button>
                                <button class="btn">
                                    <span class="material-icons">
                                        more_horiz
                                    </span>
                                </button> -->
                            </div>
                        </div>
                        <div class="item">
                            <div class="avatar-chart">
                                <img src="images/images/avatarr-default.jpeg" alt="">
                                <span class="dot -offline"></span>
                            </div>
                            <div class="text-content">
                                <div class="name">Nicholas Gordon</div>
                                <div class="pos">Developer</div>
                            </div>
                            <div class="actions">
                                <button class="btn">
                                    <span class="material-icons">
                                        question_answer
                                    </span>

                                </button>
                                <!-- <button class="btn">
                                    <span class="material-icons">
                                        phone
                                    </span>

                                </button>
                                <button class="btn">
                                    <span class="material-icons">
                                        more_horiz
                                    </span>
                                </button> -->
                            </div>
                        </div>
                        <div class="item">
                            <div class="avatar-chart">
                                <img src="images/images/avatarr-default.jpeg" alt="">
                                <span class="dot -online"></span>
                            </div>
                            <div class="text-content">
                                <div class="name">Nicholas Gordon</div>
                                <div class="pos">Developer</div>
                            </div>
                            <div class="actions">
                                <button class="btn">
                                    <span class="material-icons">
                                        question_answer
                                    </span>

                                </button>
                                <!-- <button class="btn">
                                    <span class="material-icons">
                                        phone
                                    </span>

                                </button>
                                <button class="btn">
                                    <span class="material-icons">
                                        more_horiz
                                    </span>
                                </button> -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="box-info-content" id="content-chart">
                <div class="top">
                    <a href="#" id="back" class="btn back">
                        <span class="material-icons">
                            chevron_left
                        </span>
                    </a>
                    <div class="menu-right">
                        <!-- <div class="item">
                            <a href="#" class="btn">
                                <span class="material-icons">
                                    person_add
                                </span>
                            </a>
                        </div>
                        <div class="item">
                            <a href="#" class="btn">
                                <span class="material-icons">
                                    search
                                </span>
                            </a>
                        </div> -->
                        <!-- <div class="item">
                            <div class="avatar-chart">
                                <img src="images/images/avatarr-default.jpeg" alt="">
                                <span class="dot -online"></span>
                            </div>
                        </div> -->
                    </div>
                </div>
                <div class="body">

                    <div class="chat-screen" id="chatScreen">
                        <div class="chat-header">
                            <div class="chat-title">Chat with Johanna Stevens</div>
                            <a href="#" id="closeChat" class="btn close-chat">
                                <span class="material-icons">close</span>
                            </a>
                        </div>
                        <div class="chat-body">
                            <!-- Received message -->
                            <div class="message received">
                                <div class="avatar-chart"><i class="fa-regular fa-user"></i></div>
                                <div class="message-content">
                                    <p>Hello, how can I help you today?</p>
                                    <span class="timestamp">11:24 AM</span>
                                </div>
                            </div>
                            
                            <!-- Sent message -->
                            <div class="message sent">
                                <div class="message-content">
                                    <p>Hi! I have a question about the project...</p>
                                    <span class="timestamp">11:25 AM</span>
                                </div>
                            </div>
                        </div>
                        <div class="chat-footer">
                            <div class="input-group textArea">
                                <input type="text" class="form-control" placeholder="Enter Message..." aria-label="Example text with button addon" aria-describedby="button-addon1" autofocus>
                                <button class="btn btn-outline-secondary pe-1" type="button" id="button-addon1 ms-2"><i class="fa-solid fa-microphone"></i></button>
                                <button class="btn btn-outline-secondary pe-1" type="button" id="button-addon1 ms-2"><i class="fa-solid fa-face-smile"></i></button>
                                <button class="btn btn-outline-secondary pe-1" type="button" id="button-addon1 ms-2"><i class="fa-solid fa-paperclip"></i></button>
                                <button class="btn btn-outline-secondary" type="button" id="button-addon1 ms-2"><i class="fa-solid fa-paper-plane"></i></button>
                            </div>
                        </div>
                    </div>


                    <div class="bio-div">

                        <div class="info-row">
                            <div class="key">

                            </div>
                            <div class="value user">
                                <div class="avatar-chart">
                                    <img src="images/images/avatarr-default.jpeg" alt="">
                                    <span class="dot -online"></span>
                                </div>
                                <div class="text-content">
                                    <div class="name">Johanna Stevens</div>
                                    <div class="pos">UI/UX Designer</div>
                                    <div class="actions">
                                        <button class="btn-main btn" onclick="openMsgDiv()">
                                            <span class="material-icons">
                                                question_answer
                                            </span>

                                            Message
                                            <span class="badge text-bg-danger msgCountSq">4</span>
                                        </button>
                                        
                                        <button class="btn">
                                            <span class="material-icons">
                                                phone
                                            </span>
                                        
                                        </button>
                                        <button class="btn">
                                            <span class="material-icons">
                                                open_in_browser
                                            </span>
                                        </button>
                                        <button class="btn">
                                            <span class="material-icons">
                                                more_horiz
                                            </span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="info-row">
                            <div class="key">Bio</div>
                            <div class="value">
                                When I first got into the advertising, I was looking for the magical combination that would put website into the top
                                search engine rankings
                            </div>
                            
                        </div>
                        <div class="info-row">
                            <div class="key">Email</div>
                            <div class="value">
                                <p>johanna.stevens@gmail.com</p>
                                <p>johanna.stevens@whiteui.store</p>
                            </div>
                            <div class="actions">
                                <span class="label-primary">Primary</span>
                            </div>

                        </div>
                        <div class="info-row">
                            <div class="key">Dial</div>
                            <div class="value">
                                <p>j.stevens@ymsg.com</p>
                            </div>

                        </div>
                        <div class="info-row">
                            <div class="key">Meeting</div>
                            <div class="value">
                                <p>http://go.betacall.com/meet/j.stevens</p>
                            </div>

                        </div>
                        <div class="info-row">
                            <div class="key">Phone</div>
                            <div class="value">
                                <p>439-582-1578</p>
                                <p>621-770-7689</p>
                            </div>
                            <div class="actions">
                                <span class="label-primary">Primary</span>
                            </div>
                        
                        </div>
                        <div class="info-row social">
                            <div class="key">Social</div>
                            <div class="value">
                                <button class="btn">
                                    <span class="cion">
                                        <img src="images/images/socials/Facebook.svg" alt="">
                                    </span>
                                </button>
                                <button class="btn">
                                    <span class="cion">
                                        <img src="images/images/socials/Google.svg" alt="">
                                    </span>
                                </button>
                                <button class="btn">
                                    <span class="cion">
                                        <img src="images/images/socials/LinkedIn.svg" alt="">
                                    </span>
                                </button>
                                <button class="btn">
                                    <span class="cion">
                                        <img src="images/images/socials/Pinterest.svg" alt="">
                                    </span>
                                </button>
                                <button class="btn">
                                    <span class="cion">
                                        <img src="images/images/socials/Twitter.svg" alt="">
                                    </span>
                                </button>
                            </div>
                        
                        </div>
                    </div>
                </div>
            </div>

        <div id="settings" class="container-fluid light-style flex-grow-1 container-p-y" style="overflow: auto;">
            <h4 class="font-weight-bold py-3 mb-4">
                Account settings
            </h4>
            <div class="card">
                <div class="row no-gutters row-bordered row-border-light">
                    <div class="col-md-3 pt-0">
                        <div class="list-group list-group-flush account-settings-links">
                            <a class="list-group-item list-group-item-action active" data-bs-toggle="list"
                                href="#account-general">General</a>
                            <a class="list-group-item list-group-item-action" data-bs-toggle="list"
                                href="#account-change-password">Change password</a>
                            <a class="list-group-item list-group-item-action" data-bs-toggle="list"
                                href="#account-info">Info</a>
                            <a class="list-group-item list-group-item-action" data-bs-toggle="list"
                                href="#account-social-links">Social links</a>
                            <a class="list-group-item list-group-item-action" data-bs-toggle="list"
                                href="#account-connections">Connections</a>
                            <a class="list-group-item list-group-item-action" data-bs-toggle="list"
                                href="#account-notifications">Notifications</a>
                        </div>
                    </div>
                    <div class="col-md-9">
                        <div class="tab-content">
                            <div class="tab-pane fade active show" id="account-general">
                                <div class="card-body media align-items-center">
                                    
                                    <div class="media-body ml-4">
                                        <img src="https://bootdey.com/img/Content/avatar-chart/avatar1.png" alt
                                        class="ui-w-80">
                                        <label class="btn btn-outline-primary">
                                            Upload new photo
                                            <input type="file" class="account-settings-fileinput">
                                        </label> &nbsp;
                                        <button type="button" class="btn btn-default md-btn-flat">Reset</button>
                                        <div class="text-light small mt-1">Allowed JPG, GIF or PNG. Max size of 800K</div>
                                    </div>
                                </div>
                                <hr class="border-light m-0">
                                <div class="card-body">
                                    <div class="form-group">
                                        <label class="form-label">Username</label>
                                        <input type="text" class="form-control mb-1" value="nmaxwell">
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">Name</label>
                                        <input type="text" class="form-control" value="Nelle Maxwell">
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">E-mail</label>
                                        <input type="text" class="form-control mb-1" value="nmaxwell@mail.com">
                                        <div class="alert alert-warning mt-3">
                                            Your email is not confirmed. Please check your inbox.<br>
                                            <a href="javascript:void(0)">Resend confirmation</a>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">Company</label>
                                        <input type="text" class="form-control" value="Company Ltd.">
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="account-change-password">
                                <div class="card-body pb-2">
                                    <div class="form-group">
                                        <label class="form-label">Current password</label>
                                        <input type="password" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">New password</label>
                                        <input type="password" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">Repeat new password</label>
                                        <input type="password" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="account-info">
                                <div class="card-body pb-2">
                                    <div class="form-group">
                                        <label class="form-label">Bio</label>
                                        <textarea class="form-control"
                                            rows="5">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Mauris nunc arcu, dignissim sit amet sollicitudin iaculis, vehicula id urna. Sed luctus urna nunc. Donec fermentum, magna sit amet rutrum pretium, turpis dolor molestie diam, ut lacinia diam risus eleifend sapien. Curabitur ac nibh nulla. Maecenas nec augue placerat, viverra tellus non, pulvinar risus.</textarea>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">Birthday</label>
                                        <input type="text" class="form-control" value="May 3, 1995">
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">Country</label>
                                        <select class="form-select" aria-label="Default select example">
                                            <option value="1">USA</option>
                                            <option selected>Canada</option>
                                            <option value="1">UK</option>
                                            <option value="2">Germany</option>
                                            <option value="3">France</option>
                                          </select>
                                    </div>
                                </div>
                                <hr class="border-light m-0">
                                <div class="card-body pb-2">
                                    <h6 class="mb-4">Contacts</h6>
                                    <div class="form-group">
                                        <label class="form-label">Phone</label>
                                        <input type="text" class="form-control" value="+0 (123) 456 7891">
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">Website</label>
                                        <input type="text" class="form-control" value>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="account-social-links">
                                <div class="card-body pb-2">
                                    <div class="form-group">
                                        <label class="form-label">Twitter</label>
                                        <input type="text" class="form-control" value="https://twitter.com/user">
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">Facebook</label>
                                        <input type="text" class="form-control" value="https://www.facebook.com/user">
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">Google+</label>
                                        <input type="text" class="form-control" value>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">LinkedIn</label>
                                        <input type="text" class="form-control" value>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">Instagram</label>
                                        <input type="text" class="form-control" value="https://www.instagram.com/user">
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="account-connections">
                                <div class="card-body">
                                    <button type="button" class="btn btn-twitter">Connect to
                                        <strong>Twitter</strong></button>
                                </div>
                                <hr class="border-light m-0">
                                <div class="card-body">
                                    <h5 class="mb-2">
                                        <a href="javascript:void(0)" class="float-right text-muted text-tiny"><i
                                                class="ion ion-md-close"></i> Remove</a>
                                        <i class="ion ion-logo-google text-google"></i>
                                        You are connected to Google:
                                    </h5>
                                    <a href="/cdn-cgi/l/email-protection" class="__cf_email__"
                                        data-cfemail="f9979498818e9c9595b994989095d79a9694">[email&#160;protected]</a>
                                </div>
                                <hr class="border-light m-0">
                                <div class="card-body">
                                    <button type="button" class="btn btn-facebook">Connect to
                                        <strong>Facebook</strong></button>
                                </div>
                                <hr class="border-light m-0">
                                <div class="card-body">
                                    <button type="button" class="btn btn-instagram">Connect to
                                        <strong>Instagram</strong></button>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="account-notifications">
                                <div class="card-body pb-2">
                                    <h6 class="mb-4">Activity</h6>
                                    <div class="form-group">
                                        <label class="switcher">
                                            <input type="checkbox" class="switcher-input" checked>
                                            <span class="switcher-indicator">
                                                <span class="switcher-yes"></span>
                                                <span class="switcher-no"></span>
                                            </span>
                                            <span class="switcher-label">Email me when someone comments on my article</span>
                                        </label>
                                    </div>
                                    <div class="form-group">
                                        <label class="switcher">
                                            <input type="checkbox" class="switcher-input" checked>
                                            <span class="switcher-indicator">
                                                <span class="switcher-yes"></span>
                                                <span class="switcher-no"></span>
                                            </span>
                                            <span class="switcher-label">Email me when someone answers on my forum
                                                thread</span>
                                        </label>
                                    </div>
                                    <div class="form-group">
                                        <label class="switcher">
                                            <input type="checkbox" class="switcher-input">
                                            <span class="switcher-indicator">
                                                <span class="switcher-yes"></span>
                                                <span class="switcher-no"></span>
                                            </span>
                                            <span class="switcher-label">Email me when someone follows me</span>
                                        </label>
                                    </div>
                                </div>
                                <hr class="border-light m-0">
                                <div class="card-body pb-2">
                                    <h6 class="mb-4">Application</h6>
                                    <div class="form-group">
                                        <label class="switcher">
                                            <input type="checkbox" class="switcher-input" checked>
                                            <span class="switcher-indicator">
                                                <span class="switcher-yes"></span>
                                                <span class="switcher-no"></span>
                                            </span>
                                            <span class="switcher-label">News and announcements</span>
                                        </label>
                                    </div>
                                    <div class="form-group">
                                        <label class="switcher">
                                            <input type="checkbox" class="switcher-input">
                                            <span class="switcher-indicator">
                                                <span class="switcher-yes"></span>
                                                <span class="switcher-no"></span>
                                            </span>
                                            <span class="switcher-label">Weekly product updates</span>
                                        </label>
                                    </div>
                                    <div class="form-group">
                                        <label class="switcher">
                                            <input type="checkbox" class="switcher-input" checked>
                                            <span class="switcher-indicator">
                                                <span class="switcher-yes"></span>
                                                <span class="switcher-no"></span>
                                            </span>
                                            <span class="switcher-label">Weekly blog digest</span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="mt-3 text-end mb-3">
                <button type="button" class="btn btn-primary">Save changes</button>&nbsp;
                <button type="button" class="btn btn-default">Cancel</button>
            </div>
        </div>
    </div>
</div>
 