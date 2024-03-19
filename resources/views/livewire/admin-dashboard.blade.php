<div >
<body>
    @if($show=='true')
    @livewire('add-employee-details')
    @endif
<div class="container-fluid px-1  rounded">
        <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="summary-tab" data-bs-toggle="tab" data-bs-target="#summary-tab-pane" type="button" role="tab" aria-controls="summary-tab-pane" aria-selected="true">Welcome</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="dashboard-tab" data-bs-toggle="tab" data-bs-target="#dashboard-tab-pane" type="button" role="tab" aria-controls="dashboard-tab-pane" aria-selected="false">Dashboard</button>
            </li>
        </ul>
        <div class="tab-content" id="myTabContent">
            <div class="tab-pane show active" id="summary-tab-pane" role="tabpanel" aria-labelledby="summary-tab" tabindex="0">
                <div class="row m-0 mb-4">
                    <div class="col-md-5 m-auto">
                        <h3>Welcome Bandari Divya, your dashboard is ready!</h3>
                        <p>Great Job, your affiliate dashboard is ready to go!You can view profiles,vendors,customers
                            and purchase orders.</p>
                    </div>
                    <div class="col-md-7">
                        <img src="{{ asset('images/admin_banner.png') }}" alt="Image Description" style="width: 100%;">
                    </div>
                </div>
                <div class="row m-0">
                    <div class="col-md-8">
                        <div class="row m-0">
                            <div class="col-md-4 mb-4">
                                <div class="row m-0 avaPosCard">
                                    <div class="d-flex align-items-center justify-content-center mb-4 p-0">
                                        <div class="col-8 m-0 p-0" style="text-align: start;">
                                            <h4 class="countOfNum m-0 p-0">24</h4>
                                        </div>
                                        <div class="col-4 p-0" >
                                            <img src="{{ asset('images/admin_banner.png') }}" alt="Image Description" style="width: 3em;">
                                        </div>
                                    </div>
                                    <p class="p-0 subHeading">Available Position</p>
                                    <span class="p-0 pb-3" style="color: #7c7c7c;font-size:12px;">4 Urgently needed</span>
                                </div>
                            </div>
                            <div class="col-md-4 mb-4">
                                <div class="row m-0 jobOpenCard">
                                    <div class="d-flex align-items-center justify-content-center mb-4 p-0">
                                    <div class="col-8 m-0 p-0" style="text-align: start;">
                                        <h4 class=" countOfNum m-0 p-0">4</h4>
                                    </div>
                                    <div class="col-4 p-0 " >
                                        <img src="{{ asset('images/admin_banner.png') }}" alt="Image Description" style="width: 3em;">
                                    </div>
                                    </div>
                                    <p class="p-0 subHeading">Job Open</p>
                                    <span class="p-0 pb-3" style="color: #7c7c7c;font-size:12px;">4 Active hiring</span>
                                </div>
                            </div>
                            <div class="col-md-4 mb-4">
                                <div class="row m-0 newEpmCard">
                                    <div class="d-flex align-items-center justify-content-center mb-4 p-0">
                                    <div class="col-8 p-0 m-0" style="text-align: start;">
                                        <h4 class="countOfNum m-0">10</h4>
                                    </div>
                                    <div class="col-4 p-0 " style="text-align: right">
                                        <img src="{{ asset('images/admin_banner.png') }}" alt="Image Description" style="width: 3em;">
                                    </div>
                                    </div>
                                    <p class="p-0  subHeading">New Employees</p>
                                    <span class="p-0 pb-3" style="color: #7c7c7c;font-size:12px;">4 Department</span>
                                </div>
                            </div>
                        </div>
                        <div class="row m-0">
                            <div class="col-md-6 mb-4">
                                <div class="row m-0 totalEmpCard">
                                    <div class="col-8 p-0 pb-5 pt-3">
                                        <p>Total Employees</p>
                                        <h3 class="countOfNum">150+</h3>
                                    </div>
                                    <div class="col-4 p-0 pb-5 pt-3" style="text-align: right">
                                        <img src="{{ asset('images/admin_banner.png') }}" alt="Image Description" style="width: 3em;">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 mb-4">
                                <div class="row m-0 hrReqCard">
                                    <div class="col-8 p-0 pb-5 pt-3">
                                        <p>HR Requests</p>
                                        <h3 class="countOfNum">15</h3>
                                    </div>
                                    <div class="col-4 p-0 pb-5 pt-3" style="text-align: right">
                                        <img src="{{ asset('images/admin_banner.png') }}" alt="Image Description" style="width: 3em;">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row ms-3 me-3 annocmentCard">
                            <h5 class="mt-2">Announcement</h5>
                            <div class="m-0 mb-3 row totalEmpCard" style="padding: 10px 0px;">
                                <div class="col-8">
                                    <p class="m-0">Outing schedule for every departement</p>
                                    <p class="m-0 text-gray">5 Minutes ago</p>
                                </div>
                                <div class="col-4 m-auto" style="text-align: right">
                                    <a href="#">View</a>
                                </div>
                            </div>
                            <div class="m-0 mb-3 row hrReqCard" style="padding: 10px 0px;">
                                <div class="col-8">
                                    <p class="m-0">Outing schedule for every departement</p>
                                    <p class="m-0 text-gray">5 Minutes ago</p>
                                </div>
                                <div class="col-4 m-auto" style="text-align: right">
                                    <a href="#">View</a>
                                </div>
                            </div>
                            <div class="m-0 mb-3 row newEpmCard" style="padding: 10px 0px;">
                                <div class="col-8">
                                    <p class="m-0">Outing schedule for every departement</p>
                                    <p class="m-0 text-gray">5 Minutes ago</p>
                                </div>
                                <div class="col-4 m-auto" style="text-align: right">
                                    <a href="#">View</a>
                                </div>
                            </div>
                        </div>

                        <div class="row ms-3 me-3">
                            <h5 class="mt-3 p-0">Help Links</h5>
                            <div class="m-0 p-0">
                                <span class="helpChip">attune global Community</span>
                                <span class="helpChip">Statutory Compliances</span>
                                <span class="helpChip">attune global Knowledge Center</span>
                                <span class="helpChip">Resource Center</span>
                                <span class="helpChip">How to Videos</span>
                                <span class="helpChip">attune global Academy</span>
                                <span class="helpChip">attune global FM</span>
                            </div>  
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="row m-0 mb-4 annocmentCard" style="padding: 10px 15px;">
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <div style="text-align: center;">
                                    <h6 class="m-0 pt-1" >Recently Activity</h6>
                                </div>
                                <div >
                                    <img src="{{ asset('images/admin_banner.png') }}" alt="Image Description" style="width: 3em;">
                                </div>
                            </div>
                            <p class="p-0 m-0" style="font-size: 16px;">You Posted a New Job</p>
                            <p class="p-0 pb-3" style="color: #7c7c7c; font-size: 12px;">10.40 AM, Fri 10 Dec 2023</p>
                            <button class="btn btn-primary" style="background: #02114f;">See All Activity</button>
                        </div>

                        <div class="row m-0 mb-4 annocmentCard">
                            <h5 class="mt-2">Upcoming Schedule</h5>
                            <p>Priority</p>
                            <div class="m-0 mb-3 row totalEmpCard" style="padding: 10px 0px;">
                                <div class="col-8">
                                    <p class="m-0">Review candidate applications</p>
                                    <p class="m-0 text-gray">Today - 11.30 AM</p>
                                </div>
                                <div class="col-4 m-auto" style="text-align: right">
                                    <a href="#">Action</a>
                                </div>
                            </div>
                            <p>Other</p>
                            <div class="m-0 mb-3 row hrReqCard" style="padding: 10px 0px;">
                                <div class="col-8">
                                    <p class="m-0">Outing schedule for every departement</p>
                                    <p class="m-0 text-gray">Today - 11.30 AM</p>
                                </div>
                                <div class="col-4 m-auto" style="text-align: right">
                                    <a href="#">Action</a>
                                </div>
                            </div>
                            <div class="m-0 mb-3 row newEpmCard" style="padding: 10px 0px;">
                                <div class="col-8">
                                    <p class="m-0">Outing schedule for every departement</p>
                                    <p class="m-0 text-gray">Today - 11.30 AM</p>
                                </div>
                                <div class="col-4 m-auto" style="text-align: right">
                                    <a href="#">Action</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="tab-pane" id="dashboard-tab-pane" role="tabpanel" aria-labelledby="dashboard-tab" tabindex="0">
                <div class="bg-white p-1 d-flex flex-row justify-content-between  mb-2">
                    <div class="col-8 d-flex flex-row justify-content-between mt-2 mb-4" style="text-align:start;">
                        <div class="col d-flex flex-column" style="padding: 10px 20px;border-radius: 5px;background:#ffe2c3; color:rgb(2, 17, 79); margin-right: 7px;box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2);">
                            <p class="font-weight-500" style="font-size:13px;">Add Employee</p>
                            <a class="text-decoration-none" href="{{ route('add-employee-details') }}">
                                <i class="fa-solid fa-user-plus" style="display:flex;justify-content:center;cursor:pointer;"></i>
                            </a>

                        </div>
                        <div class="col d-flex flex-column" style="padding: 10px 20px;border-radius: 5px;background:#c3e0ff; color:rgb(2, 17, 79); margin-right: 7px;box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2);">
                            <p class="font-weight-500" style="font-size:13px;">Update Employee</p>
                            <a class="text-decoration-none" href="{{ route('update-employee-details') }}">
                                <i class="fa-solid fa-user-plus" style="display:flex;justify-content:center;cursor:pointer;"></i>
                            </a>
                        </div>
                        <div class="col d-flex flex-column" style="padding: 10px 20px;border-radius: 5px;background:#e2c3ff; color:rgb(2, 17, 79);box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2);">
                            <p class="font-weight-500" style="font-size:13px;">Add Payroll</p>
                        </div>
                    </div>
                    <div class="col-4 p-2">
                        <div class="rounded" style="border:1px solid #ccc;background:#fffaea;">
                             
                        </div>
                    </div>
                </div>
                <div class="row m-0 mt-4 mb-4">
                    <div class="col-md-6 mb-4">
                        <div style="position: relative; width:100%">
                            <canvas id="yearsInServiceChart"></canvas>
                        </div>
                    </div>
                    <div class="col-md-6 mb-4">
                        <div style="position: relative; width:100%">
                            <canvas id="additionAndAttrition"></canvas>
                        </div>
                    </div>
                    <div class="col-md-6 mb-4">
                        <div style="position: relative; width:100%">
                            <canvas id="emplCountByLocation"></canvas>
                        </div>
                    </div>
                    
                    <div class="col-md-6 mb-4">
                        <div class="table-responsive p-4" style="background: white">
                            <h4 style="color: #02114f; font-weight: 600">Top 5 Leave Takers</h4>
                            <p>01 Oct 2023 to 31 Jan 2024</p>
                            <table class="table table-bordered">
                                <thead class="table-dark">
                                    <tr>
                                        <th scope="col">Emp No.</th>
                                        <th scope="col">Name</th>
                                        <th scope="col">Day</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>XSS-0237</td>
                                        <td>Sai Kinnarn Kotha</td>
                                        <td>40</td>
                                    </tr>
                                    <tr>
                                        <td>XSS-0987</td>
                                        <td>Thornton</td>
                                        <td>13</td>
                                    </tr>
                                    <tr>
                                        <td>XSS-1267</td>
                                        <td>Larry the Bird</td>
                                        <td>34</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="col-md-6 mb-4">
                        <div style="position: relative; width:100%">
                            <canvas id="genderChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- <nav>
            <ul class="nav nav-tabs" id="nav-tab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab"
                        aria-controls="nav-home" aria-selected="true">Summary</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="nav-profile-tab" data-toggle="tab" href="#nav-profile" role="tab"
                        aria-controls="nav-profile" aria-selected="false">Dashboard</a>
                </li>
            </ul>
        </nav>
        <div class="tab-content" id="nav-tabContent">
            <div class="tab-pane show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                <div class="bg-white p-3 mb-3 rounded" style="display:flex;gap:5px;text-align:start;justify-content:center;">
                    <div class="text">
                        <h6>Welcome Bandari Divya, your dashboard is ready!</h6>
                        <p>Great Job, your affiliate dashboard is ready to go!You can view profiles,vendors,customers
                            and purchase orders.</p>
                    </div>
                    <div class="image" >
                        <img src="https://img.freepik.com/free-vector/modern-business-team-working-open-office-space_74855-5541.jpg"
                            alt="" class="img-fluid" height="180px" width="200px">
                    </div>
                </div>
                <div class="row mx-0 px-0 d-flex justify-content-between flex-wrap">
                    <div class="col-md-8 px-0">
                        <div class=" flex-wrap px-0 " style="display:flex;gap:5px;text-align:start;">
                            <div class="first col mb-1 p-2 rounded bg-white">
                                <p>Available Position</p>
                                <h6>24</h6>
                                <span>4 Urgently needed</span>
                            </div>
                            <div class="first col mb-1 p-2 rounded bg-white text-content-start">
                                <p>Job Open</p>
                                <h6>4</h6>
                                <span>4 Active hiring</span>
                            </div>
                            <div class="first col mb-1 p-2 rounded bg-white text-content-start">
                                <p>New Employees</p>
                                <h6>10</h6>
                                <span>2 Department</span>
                            </div>
                        </div>
                        <div class="d-flex flex-wrap" style="display:flex;gap:5px;">
                            <div class="first col mb-1 p-2 mt-1 rounded bg-white d-flex align-items-center">
                                <div class="d-flex flex-column gap-10px">
                                    <p>Total Employees</p>
                                    <h6>150+</h6>
                                </div>
                                <div>
                                    <img src="{{ asset('/images/Vector 3.png' ) }}" alt="">
                                </div>
                            </div>
                            <div class="first col mb-1 p-2 mt-1 rounded bg-white d-flex align-items-center">
                                <div class="d-flex flex-column gap-10px">
                                    <p>HR Requests</p>
                                    <h6>15</h6>
                                </div>
                            </div>
                        </div>
                        <div class="first col mb-1 p-2 mt-1 rounded bg-white d-flex flex-column align-items-start">
                            <div style="font-size: 11px; color: rgb(2, 17, 79); font-weight: 500;">
                                <h6>Announcement</h6>
                            </div>
                            <div class="d-flex flex-column gap-10px" style="width: 100%;">
                                <div class="d-flex flex-row rounded bg-white justify-content-between mb-2" style="border: 1px solid #ccc;font-size:12px;padding:5px;">
                                    <p class="font-weight-normal ">Outing schedule for every departement 
                                </p>
                                <span>5 Minutes ago</span>
                                   
                                </div>
                                <div class="d-flex flex-row rounded bg-white justify-content-between" style="border: 1px solid #ccc;font-size:12px;padding:5px;">
                                    <p class="font-weight-normal">Outing schedule for every departement 
                                </p>
                                <span>5 Minutes ago</span>
                                   
                                </div>
                               
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 ">
                        <div class="col-12 mb-2 p-0">
                            <div class="admin-card mx-0 bg-white rounded" style="box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2);">
                                <div class="card-header" style="background:rgb(2, 17, 79);color:white;padding:4px;font-size:14px;font-weight:500;">
                                    Recently Activity
                                </div>
                                <div class="card-body">
                                    <span class="small-text">10.40 AM, Fri 10 Dec 2023 <br>
                                      <h6 class="card-title">You Posted a New Job</h6>
                                    </span>
                                    <p class="card-text">With supporting text below as a natural lead-in to additional
                                        content.</p>
                                    <div style="display:flex;justify-content:end;">
                                          <a href="#" class="activitya btn-start">See All Activity</a>
                                    </div>
                                </div>
                            </div>
                            <div class="bg-white mt-2 rounded" style="border:1px solid #CCC;padding:10px 0;box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2);">
                                <div class="container m-0 rounded bg-white" >
                                    <div class="d-flex flex-row justify-content-between">
                                        <p style="font-size:14px;color:rgb(2, 17, 79);font-weight:500;">Upcoming Schedule</p>
                                    </div>
                                    <div class="d-flex flex-column align-items-start" style="width:100%;">
                                        <p style="font-size:11px;font-weight:500;">Priority</p>
                                        <div class="d-flex flex-row align-items-start bg-white rounded" style="border:1px solid #ccc;padding:5px;width:100%;">
                                            <div class="d-flex flex-column text-align-start">
                                               <p style="font-size: 0.755rem; word-break: break-all;color:#778899;">
                                                    Review candidate applications <br>
                                                    <span style="font-size: 0.625rem;">Today - 11.30 AM</span>
                                                </p>
                                            </div>
                                            <div>
                                                <i class="fa-solid fa-ellipsis " style="color:#ccc;"></i>
                                            </div>
                                        </div>
                                        <p class="mt-1"style="font-size:11px;font-weight:500;">Other</p>
                                        <div class="bg-white rounded" style="display: flex; flex-direction: row; text-align: start; align-items: center; justify-content: center; gap: 42px; padding:5px;border:1px solid #ccc;width:100%;">
                                            <div>
                                            <p style="font-size: 0.755rem; word-break: break-all;color:#778899;">
                                                    Review candidate applications <br>
                                                    <span style="font-size: 0.625rem;">Today - 11.30 AM</span>
                                                </p>
                                            </div>
                                            <div>
                                                <i class="fa-solid fa-ellipsis " style="color:#ccc;"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>  
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="tab-pane" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
               <div class="bg-white p-1 d-flex flex-row justify-content-between  mb-2">
                    <div class="col-8 d-flex flex-row justify-content-between mt-2 mb-2" style="text-align:start;">
                        <div class="col d-flex flex-column rounded p-1" style="background:#ffe2c3; color:rgb(2, 17, 79); margin-right: 7px;box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2);">
                            <p class="font-weight-500" style="font-size:13px;">Add Employee</p>
                            <a class="text-decoration-none" href="{{ route('add-employee-details') }}">
                                <i class="fa-solid fa-user-plus" style="display:flex;justify-content:center;cursor:pointer;"></i>
                            </a>

                        </div>
                        <div class="col d-flex flex-column rounded p-1" style="background:#c3e0ff; color:rgb(2, 17, 79); margin-right: 7px;box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2);">
                            <p class="font-weight-500" style="font-size:13px;">Update Employee</p>
                            <a class="text-decoration-none" href="{{ route('update-employee-details') }}">
                                <i class="fa-solid fa-user-plus" style="display:flex;justify-content:center;cursor:pointer;"></i>
                            </a>
                        </div>
                        <div class="col d-flex flex-column rounded p-1" style="background:#e2c3ff; color:rgb(2, 17, 79);box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2);">
                            <p class="font-weight-500" style="font-size:13px;">Add Payroll</p>
                        </div>
                    </div>
                    <div class="col-4 p-2">
                        <div class="rounded" style="border:1px solid #ccc;background:#fffaea;">
                             
                        </div>
                    </div>
                </div>
            </div>
        </div> -->
    </div>


<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
  const ctx1 = document.getElementById('yearsInServiceChart');
  const plugin = {
    id: 'customCanvasBackgroundColor',
    beforeDraw: (chart, args, options) => {
        const {ctx} = chart;
        ctx.save();
        ctx.globalCompositeOperation = 'destination-over';
        ctx.fillStyle = options.color || '#99ffff';
        ctx.fillRect(0, 0, chart.width, chart.height);
        ctx.restore();
    }
  };

  new Chart(ctx1, {
    type: 'line',
    data: {
      labels: ['Red', 'Blue', 'Yellow', 'Green', 'Purple', 'Orange'],
      datasets: [{
        label: 'Years',
        data: [12, 19, 3, 5, 2, 3],
        borderWidth: 1
      }]
    },
    options: {
        plugins: {
            title: {
                display: true,
                text: 'Years in Service Distribution',
            },
            customCanvasBackgroundColor: {
                color: 'white',
            }
        },
      scales: {
        y: {
            title: {
            display: true,
            text: 'Employee',
          },
          beginAtZero: true
        },
        x: {
            title: {
            display: true,
            text: 'Years',
          }
        }
      }
    },
    plugins: [plugin],
  });

  const ctx2 = document.getElementById('additionAndAttrition');

  new Chart(ctx2, {
    type: 'line',
    data: {
      labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
      datasets: [
        {
            label: 'Joined',
            data: [12, 19, 3, 5, 2, 3],
            borderWidth: 1
        },
        {
            label: 'Resigned',
            data: [3, 19, 12, 15, 12, 3],
            borderWidth: 1
        }
     ]
    },
    options: {
        plugins: {
            title: {
        display: true,
        text: 'Addition & Attribution (Feb-2023 to Jan-2024)',
      },
            customCanvasBackgroundColor: {
                color: 'white',
            }
        },
      scales: {
        y: {
            title: {
            display: true,
            text: 'Employees',
          },
          beginAtZero: true
        },
        x: {
            title: {
            display: true,
            text: 'Months',
          }
        }
      }
    },
    plugins: [plugin],
  });

  const ctx3 = document.getElementById('emplCountByLocation');

  new Chart(ctx3, {
    type: 'bar',
    data: {
      labels: ['Hyderabad', 'Udaipur', 'Bhubneswar', 'Bangalore'],
      datasets: [{
        label: 'Count',
        data: [12, 19, 3, 5],
        borderWidth: 1
      }]
    },
    options: {
        indexAxis: 'y',
        elements: {
            bar: {
                borderWidth: 3,
            }
        },
        responsive: true,
        plugins: {
            legend: {
                position: 'right',
            },
            title: {
                display: true,
                text: 'Employee Count By Location',
            },
            customCanvasBackgroundColor: {
                color: 'white',
            }
        },
    },
    plugins: [plugin],
  });

  const ctx4 = document.getElementById('genderChart');

  new Chart(ctx4, {
    type: 'pie',
    data: {
        labels: [
            'Male',
            'Female',
            'Not Active'
        ],
        datasets: [{
            label: 'My First Dataset',
            data: [300, 50, 100],
            backgroundColor: [
                'rgb(255, 99, 132)',
                'rgb(54, 162, 235)',
                'rgb(255, 205, 86)'
            ],
            hoverOffset: 4
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: {
                position: 'top',
            },
            title: {
                display: true,
                text: 'Gender Distribution - Current Employees',
            },
            customCanvasBackgroundColor: {
                color: 'white',
            }
        },
    },
    plugins: [plugin],
  });
</script>

</body>
</html>
</div>