<div style="width:98%;">

  <style>
    .container-box-for-employee-information-who-is-in{
    width: 82%;
    display: flex;
    flex-direction: column;
    border: 1px solid #ccc;
    margin-top: 30px;
    margin-left: 10px;
    align-items: center;
    justify-content: center;
    background-color: #ffff;
    border: 1px solid #ccc;
    flex: 1;
  }
  
.cont{
  display:flex; 
  justify-content: space-between; 
  margin-top:50px;
}

  .field-for-employee-who-is-in{

    text-align: center;
    width: 100%;
    align-items: center;
    background-color: #ffffff;
    border-right: 1px solid #ccc;
    flex: 1;
  }

  .percentage-who-is-in {
   
    font-weight: 600;
 
    font-size:13px; 

  }

  .employee-count-who-is-in {
    font-size: 12px;
   
    padding-bottom: 7px;

  }

  .heading-who-is-in {
    display: flex;
    justify-content: space-between;
    padding: 8px 15px;
    margin-top:-15px;
  }

  .heading-who-is-in i {
    color: #778899;
    cursor:pointer;
    padding-top:20px;
  }

  .heading-who-is-in h3 {
    color: #778899;
    font-size: 14px;
    font-weight: 500;
  }

  .container3-who-is-in {
    background-color: #ffffff;
    margin-top: 10px;
    border-radius: 10px;
    border: 1px solid #ccc;
    /* Border style for the container */
  }

  .container5-who-is-in  {
    /* Adjust the width as needed */
    background-color: #FFFFFF;
    margin-top: 10px;
    border-radius: 10px;
    border: 1px solid #ccc;
    /* Border style for the container */
  }


  .container6-who-is-in  {
    background-color: #FFFFFF;
    margin-top: 10px;
    border-radius: 10px;
    border: 1px solid #ccc;
    /* Border style for the container */
  }

  .container4-who-is-in {
    background-color: #FFFFFF;
    margin-top: 10px;
    border-radius: 10px;
    border: 1px solid #ccc;
    /* Border style for the container */
  }
  

  .who-is-in-table{
    border-collapse: collapse;
    width: 100%;
    max-height: 200px;
    /* Set the max height you prefer */
    overflow-y: auto;
    overflow-x: hidden;
    display: block;

  }

  /* CSS for the table header (thead) */
  .who-is-in-table thead {
    background-color: rgb(2, 17, 79);
    color: white;
    width: 100%;
  }
  input::placeholder {
  font: 0.85rem/3 sans-serif;
   }
  /* CSS for the table header cells (th) */
  .who-is-in-table
  {
    margin-top:-10px
  }
  .who-is-in-table th {
    padding: 5px 20px;
    text-align: left;
    width: 100%;
    font-weight: normal;
    font-size: 12px;
  }

  .who-is-in-table td {
    /* Add borders to separate cells */
    padding: 5px 20px;
    text-align: left;
   
    font-weight: normal; 
    font-size: 12px;
    
  }
  .who-is-in-table tr{
    border-bottom: 1px solid #ddd;
  }

  input[type="date"]::before {
    content: attr(placeholder);
    color: #778899;
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    pointer-events: none;
    z-index: -1;
  }

  .date-form-who-is-in {
    display: flex;
    align-items: start;
    justify-content: start;
    width: 200px;
    
   
   
  }
  .date-form-who-is-in input {
     /* Remove the input border */
    width: 100%;
    box-sizing: border-box;
    border: 1px solid #778899; 
    border-radius:5px;
   
}
 
  .shift-selector-container-who-is-in {
    position: relative;
    width: 200px;
    
    margin-top:30px;/* Adjust the width as needed */
  }

  .shift-selector-who-is-in{
    width: 100%;
    height:60px;
    padding: 10px;
    box-sizing: border-box;
    border: 1px solid #ccc;
    border-radius: 5px;
    appearance: none;
    -webkit-appearance: none;
    -moz-appearance: none;
    background-color: #fff;
    cursor: pointer;
    position: relative;
  }
  .arrow-who-is-in {
    position: absolute;
    top: 20%;
    right: 10px;
    width: 10px; /* Adjust the width of the arrow line */
    height: 0.8px; /* Adjust the height of the arrow line */
    transform: translateY(-90%) rotate(-45deg);
    background-color: black;
}
.no-record-found-who-is-in
{
  text-align: center;
}

.arrow-who-is-in::before {
    content: '';
    position: absolute;
    top: 50%;
    right: 0;
    transform: translateY(-60%) rotate(45deg);
    width: 5px; /* Adjust the size of the arrowhead */
    height: 5px; /* Adjust the size of the arrowhead */
    border-right: 1px solid black; /* Adjust the thickness and color of the arrowhead */
    border-top: 1px solid black; /* Adjust the thickness and color of the arrowhead */
}
  .search-container-who-is-in {
    display: flex;
    margin-top:-90px;
    margin-left: auto;
  }
  .search-text::placeholder {
   
   font-size:12px;
  
  
}
  .shift-selector-who-is-in::placeholder {
   
    font-size:12px;
    position: absolute;
    top: 10px; /* Adjust this value as needed */
}

  .form-group-who-is-in {
    margin-right: 10px;
    /* Add spacing between search input and other elements */
  }

  .search-input-who-is-in {
    border: none;
    position: relative;
    margin-top:50px;
  }

  .search-input-who-is-in input[type="text"] {
    padding: 5px;
    border: 1px solid #ccc;
    border-radius: 4px;
    width: 200px;
    /* Adjust width as needed */
  }

  .search-icon-who-is-in {
    position: absolute;
    top: 50%;
    right: 10px;
    color: #778899;
    transform: translateY(-50%);
    cursor: pointer;
    font-weight: 300;
}

.search-icon-who-is-in::before {
    /* Unicode character for a magnifying glass */
    font-size: 16px;
     /* Adjust the font-weight to make it less thick */
}

  .filter-container1-who-is-in {
    display: flex;
    background: #fff;
    align-items: center;
    height: 30px;
    width: 30px;
    padding: 5px;
    border: 1px solid #ccc;
    margin-top:-40px
  }

  .filter-group-who-is-in {
    display: flex;
    align-items: center;
    margin-top:0px;
  }

  /* Styles for the Font Awesome icon */
  .fa-icon {
    font-size: 14px;
    color: #778899;
    /* Add spacing between icon and text */
  }
  .employee-information-container-who-is-in
  {
    margin-top:5px;
    display:flex;
    align-items:center;
    text-align:center;
    justify-content:center;
    padding:0;
  }
  .employee-information-sentence-text-who-is-in
  {
    text-align:center;
    font-size:14px;
  }
  .search-results-who-is-in {
    position: fixed;
    background: white;
    margin-top:-13px;
    overflow-y: scroll;
    max-height: 200px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    width: 195px;
    /* Adjust the width as needed */
    z-index: 999;

  }
.drop-down-for-who-is-in{
  border: none;
}
  .search-results-who-is-in ul {
    list-style: none;
    padding: 0;
    margin: 0;
  }

  .search-results-who-is-in li {
    padding: 5px;
    border-bottom: 1px solid #eee;
  }
  .date-who-is-in
  {
    color: #778899;
   
    width:200px;
  }
  .current-date-who-is-in
  {
    font-weight: 600;
  }
  .content-who-is-in{
    display:flex;
    flex-direction:row;
    justify-content:space-between;
    padding:0; 
    border-top:1px solid #ccc;
  }
  .content-for-not-yet-in
  {
    display:flex;
     gap:10px; 
     margin-top:10px; 
      width:95%;

  }
  .accordion-content {
    background-color: #f2f2f2;
    padding: 10px;
    border: 1px solid #ddd;
    border-radius: 5px;
}

.time-range {
    font-weight: bold;
    margin-bottom: 10px;
}

.time-indicator {
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.start-time,
.end-time {
    width: 50%;
    text-align: center;
}
  </style>  
 
  <div class="date-form-who-is-in">
      <input type="date" wire:model="from_date" wire:change="updateDate" class="date-who-is-in" id="fromDate" name="fromDate" >
   
  </div>
 
<div class="shift-selector-container-who-is-in"wire:click="togglePopup">
  <input type="text" class="shift-selector-who-is-in " placeholder="Select Shifts">
  <div class="arrow-who-is-in"></div>
   
</div>
@if($this->showPopup==true)
    @livewire('shift-selector-popup')
@endif   
<div class="cont">
  <div class="search-container-who-is-in" >
   
       
        <div class="form-group-who-is-in">
            <div class="search-input-who-is-in">
                <input wire:model="search" type="text" placeholder="Search by name or ID" class="search-text">
                <div class="search-icon-who-is-in" wire:click="searchFilters">
                    <i class="fa fa-search" aria-hidden="true"></i>
                </div>
            </div>
        </div>
 
 
       
         
         
         
        </div>
     
     
       
   
 
 
 
 
 
  <div class="filter-container1-who-is-in">
    <div class="filter-group-who-is-in">
      <i class="fa-icon fas fa-filter"></i> <!-- Font Awesome filter icon -->
      <gt-filter-group-who-is-in>
        <!-- Add more content as needed -->
      </gt-filter-group-who-is-in>
    </div>
  </div>
</div>
<div class="container-box-for-employee-information-who-is-in">
  <!-- Your content goes here -->
  <div class="employee-information-container-who-is-in">
    <p class="employee-information-sentence-text-who-is-in">Employees Information for  <span class="current-date-who-is-in">{{ \Carbon\Carbon::parse($currentDate)->format('d M, Y') }}</span></p>
  </div>
 
  <div class="content-who-is-in">
    <div class="col-md-3 field-for-employee-who-is-in">
      <div class="percentage-who-is-in">{{number_format($absentpercentage, 2)}}%</div>
      <div class="employee-count-who-is-in">{{$absentemployeescount}}&nbsp;Employee(s)&nbsp;are&nbsp;Absent</div>
      
    </div>
    <div class="col-md-3 field-for-employee-who-is-in">
      <div class="percentage-who-is-in">{{number_format($latepercentage, 2)}}%</div>
      <div class="employee-count-who-is-in">{{$lateemployeescount}}&nbsp;Employee(s)&nbsp;are&nbsp;Late&nbsp;In</div>
 
    </div>
    <div class="col-md-3 field-for-employee-who-is-in">
      <div class="percentage-who-is-in">{{number_format($earlypercentage, 2)}}%</div>
      <div class="employee-count-who-is-in">{{$earlyemployeescount}}&nbsp;Employee(s)&nbsp;are&nbsp;On&nbsp;Time</div>
    </div>
    <div class="col-md-3 field-for-employee-who-is-in">
      <div class="percentage-who-is-in">0%</div>
      <div class="employee-count-who-is-in">0&nbsp;Employee(s)&nbsp;are&nbsp;On&nbsp;Leave</div>
    </div>
  </div>
</div>

<!-- containers for attendace -->
<div class="content-for-not-yet-in">
  <div class="col-md-6">
    <div class="container3-who-is-in">
      <div class="heading-who-is-in">
        <h3>Not&nbsp;Yet&nbsp;In({{$absentemployeescount}}) </h3>
       
             <i class="fas fa-download"wire:click="downloadExcelForAbsent"></i>
         
      </div>
      <div>
        <table class="who-is-in-table">
          <thead>
            <tr>
              <th>Employee</th>
              <th>Expected&nbsp;In&nbsp;Time</th>
              <th></th>
            </tr>
            <tr>
              <th style="background-color: #fff"></th>
            </tr>
          </thead>
         
         
          <tbody>
         
          
              @if($absentemployees->count() > 0)         
                 @foreach($absentemployees as $employees)
                              <tr>
                                <td style="font-size:13px;font-weight:500;">  {{ ucwords(strtolower($employees->first_name)) }}&nbsp;{{ucwords(strtolower($employees->last_name))}}<br /><span class="text-muted"style="font-weight:normal;font-size:10px;">#{{$employees->emp_id}}</span></td>
                                <td style="font-weight:normal;font-size:13px;">10:00:00
                                   
                                </td>
                                <td> <button class="drop-down-for-who-is-in" wire:click="toggleAccordion('{{ $employees->emp_id }}')">&#x25BC;</button>
                                </td>
                              </tr>
                              <tr>
                              <td>
                              @if (isset($openRows[$employees->emp_id]))
                                     <div class="accordion-content" style="text-align: center;">
                                           <div class="time-range">
                                               <p>10:00 AM to 07:00 PM</p>
                                           </div>
 
                                           <div class="time-indicator">
                                               <div class="start-time">10:00</div>
                                                <hr />
                                               <div class="end-time">07:00</div>
                                           </div>
                                           <div class="contact-details">
                                               {{$employees->emp_id}}
                                               
                                               
                                                <p>Contact Details:</p>
                                                <p>Phone:  {{ $employees->mobile_number }}</p>
                                                <p>Email: {{ $employees->company_email }}</p>
                                           </div>
                                      </div>
                                @endif
                              </td>
                              </tr>

                 @endforeach
              @else
                            <tr>
                                <td colspan="2" style="text-align: center;">
                                  <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQi7kQkKftvg3JCfA63d_BWJbSNrTwsX9QQPRUS7Okm5iTciCkig3wOxRUQB59BO6AM0Ng&usqp=CAU" style="width: 30px;">
                                  <p style="font-weight: normal; font-size: 12px; color:#778899;margin-top:5px;">Team's on the way</p>
                                </td>
                            </tr>
              @endif              
        
            <!-- Add more rows with dashes as needed -->
          
          </tbody>
 
         
          <!-- Add table rows (tbody) and data here if needed -->
        </table>
 
      </div>
 
    </div>
  </div>
  <div class="col-md-6">
    <div class="container4-who-is-in">
      <div class="heading-who-is-in"style="margin-top:-15px;">
        <h3>Late&nbsp;Arrivals&nbsp;({{ str_pad($lateemployeescount, 2, '0', STR_PAD_LEFT) }})</h3>
       
             <i class="fas fa-download"wire:click="downloadExcelForLateArrivals"style="cursor:pointer;padding-top:20px;"></i>
           
      </div>
      <div>
        <table class="who-is-in-table" style="margin-top:-10px">
          <thead>
            <tr>
              <th>Employee</th>
              <th>Late&nbsp;By</th>
               
            </tr>
          </thead>
          <tbody>
          @if($lateemployees->count()>0)

              @foreach($lateemployees as $p)
                <tr style="border-bottom: 1px solid #ddd;">
                  <td style="font-size:13px;font-weight:500;">{{ucfirst(strtolower($p->first_name))}}&nbsp;{{ucfirst(strtolower($p->last_name))}}<br /><span class="text-muted"style="font-weight:normal;font-size:10px;">#{{$p->emp_id}}</span></td>
                  <td style="font-weight:normal;font-size:13px;">
                  @php
                    $swipeTime = \Carbon\Carbon::parse($p->swipe_time);
                    $lateTime = \Carbon\Carbon::parse('10:00:00');
                    $diff = $swipeTime->diff($lateTime);
                  
                @endphp
                {{ $diff->format('%H:%I')}}
                  <br /><span class="text-muted"style="font-size:10px;font-weight:300;">{{$p->swipe_time}}</span>
                
                </td>
                <td> <button wire:click="toggleAccordion('{{ $p->emp_id }}')">&#x25BC;</button>
                      
               
                      @if(isset($openRows[$p->emp_id]))
                        <div class="accordion-content" style="text-align: center;">
                                       <div class="time-range">
                                           <p>10:00 AM to 07:00 PM</p>
                                       </div>

                                       <div class="time-indicator">
                                           <div class="start-time">10:00</div>
                                           <div class="end-time">07:00</div>
                                       </div>
                                       <div class="contact-details">
                                           {{$p->emp_id}}
                                           
                                           
                                            <p>Contact Details:</p>
                                            <p>Phone:  {{ $p->mobile_number }}</p>
                                            <p>Email: {{ $p->company_email }}</p>
                                       </div>
                    </div>
                    @endif
                    </td>    
                 </tr>
              @endforeach
          @else
           <tr>
               <td colspan="2" style="text-align: center;">
                   <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQi7kQkKftvg3JCfA63d_BWJbSNrTwsX9QQPRUS7Okm5iTciCkig3wOxRUQB59BO6AM0Ng&usqp=CAU" style="width: 30px;">
                   <p style="font-weight: normal; font-size: 12px; color:#778899;margin-top:5px;">Team's on the way</p>
                </td>
            </tr>  
            
          @endif
      
          </tbody>
 
        </table>
 
      </div>
 
    </div>
  </div>
</div>
<div class="content">
  <!-- third col -->
  <div class="col-md-6">
    <div class="container5-who-is-in">
      <div class="heading-who-is-in"style="margin-top:-15px;">
        <h3>On&nbsp;Time&nbsp;({{ str_pad($earlyemployeescount, 2, '0', STR_PAD_LEFT) }})</h3>
           
                  <i class="fas fa-download"wire:click="downloadExcelForEarlyArrivals"style="cursor:pointer;padding-top:20px;"></i>
               
      </div>
 
      <div>
        <table class="who-is-in-table"style="margin-top:-10px">
          <thead>
            <tr>
              <th>Employee</th>
              <th>Early&nbsp;By</th>
 
            </tr>
          </thead>
          <tbody>
          @if($earlyemployees->count()>0)

            @foreach($earlyemployees as $e)
            <tr style="border-bottom: 1px solid #ddd;">
              <td style="font-size:13px;font-weight:500;">{{ucfirst(strtolower($e->first_name))}}&nbsp;{{ucfirst(strtolower($e->last_name))}}<br /><span class="text-muted"style="font-weight:normal;font-size:10px;">#{{$e->emp_id}}</span></td>
              <td style="font-weight:normal;font-size:13px;">
                    
                          
                          @php
                              $swipeTime = \Carbon\Carbon::parse($e->swipe_time);
                              $earlyTime = \Carbon\Carbon::parse('10:00:00');
                              $diff = $earlyTime->diff($swipeTime);
                              
                          @endphp
                          {{$diff->format('%H:%I')}}
                        <br />
                          <span class="text-muted"style="font-size:10px;font-weight:300;">{{$e->swipe_time}} 
                              
                          </span>
                          
                          
                      </td>
                      <td> <button wire:click="toggleAccordion('{{ $e->emp_id }}')">&#x25BC;</button>
                      
               
                      @if(isset($openRows[$e->emp_id]))
                        <div class="accordion-content" style="text-align: center;">
                                       <div class="time-range">
                                           <p>10:00 AM to 07:00 PM</p>
                                       </div>

                                       <div class="time-indicator">
                                           <div class="start-time">10:00-----</div>
                                           <div class="end-time">-----07:00</div>
                                       </div>
                                       <div class="contact-details">
                                           {{$e->emp_id}}
                                           
                                           
                                            <p>Contact Details:</p>
                                            <p>Phone:  {{ $e->mobile_number }}</p>
                                            <p>Email: {{ $e->company_email }}</p>
                                       </div>
                    </div>
                    @endif
                    </td>   
                       
            </tr>
            @endforeach
          @else
           <tr>
               <td colspan="2" style="text-align: center;">
                   <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQi7kQkKftvg3JCfA63d_BWJbSNrTwsX9QQPRUS7Okm5iTciCkig3wOxRUQB59BO6AM0Ng&usqp=CAU" style="width: 30px;">
                   <p style="font-weight: normal; font-size: 12px; color:#778899;margin-top:5px;">Team's on the way</p>
                </td>
           </tr>
           @endif   
            
          
          </tbody><!-- Add table rows (tbody) and data here if needed -->
        </table>
      </div>
    </div>
  </div>
  <div class="col-md-6">
    <div class="container6-who-is-in">
      <div class="heading-who-is-in"style="margin-top:-15px;">
        <h3>On&nbsp;Leave&nbsp;(00)</h3>
             
                    <i class="fas fa-download"wire:click="downloadExcelForLeave" style="cursor: pointer;padding-top:20px;"></i>
                 
      </div>
 
 
      <div>
        <table class="who-is-in-table" style="margin-top:-10px">
          <thead>
            <tr>
              <th>Employee</th>
              <th>Number&nbsp;of&nbsp;days</th>
 
            </tr>
          </thead>
          <tbody>
         
            <tr>
               <td colspan="2" style="text-align: center;">
                   <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQi7kQkKftvg3JCfA63d_BWJbSNrTwsX9QQPRUS7Okm5iTciCkig3wOxRUQB59BO6AM0Ng&usqp=CAU" style="width: 30px;">
                   <p style="font-weight: normal; font-size: 12px; color:#778899;margin-top:5px;">Team's on the way</p>
                </td>
            </tr>
 
       
           
            
 
 
            
          </tbody>
          <!-- Add table rows (tbody) and data here if needed -->
        </table>
      </div>
      
    </div>
  </div>
</div>
<script>
    function toggleCollapse(collapseId) {
        var collapseElement = document.getElementById(collapseId);
        collapseElement.classList.toggle("show");
    }
</script>
</div>