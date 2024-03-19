<div>
<!DOCTYPE html>
<html lang="en">
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
<style>
 .container,
.delegate-form-container{
  height: 500px;
  background: white;
  border-radius: 5px;
  border: 1px solid silver;
  box-sizing: border-box;

}


  /* Media query for smaller screens */

  body {
            margin: 0;
            padding: 0;
            font-family: "montserrat", sans-serif;
            background-color: #f5f5f5;
        }

        .body {
            font-family: 'Montserrat';
            font-size:10px;
            margin-left: 300px;
        }
        .btn {
            font-family: 'Montserrat';
        }
          .header {
            background-color: #3771C8;
            color: #fff;
            padding: 10px 0;
            text-align: center;
        }
 
</style>
<div style="display: flex;">
  <div class="container" style="width: 700px; margin-left:40px"> 
  @foreach($employees as $employee)

    
<h5 style="color:orange;margin-top:30px;margin-left:40px"><b>WorkFlow Delegates</b></h5>
<button wire:click="submitForm" id="show-delegate-form-button" style=" width: 120px; height: 30px; border-radius:5px;border:1px solid silver;background:rgb(2, 17, 79);color:white;margin-left:500px;font-size:12px">Add Delegates</button>
<div class="container" style="height:300px;width:640px;border-radius:5px;border:1px solid grey;margin-top:20px;margin-left:10px">
<div class="row" style="height:20px;background:rgb(2, 17, 79);;margin-top:5px;width:100%;margin-left:1px ">
<h6 style="color:white;font-size:10px">WorkFlow Delegates</h6>
</div>

<table style="width: 100%; border-collapse: collapse;">

<thead  style="background:#e0ffff ">
                    <tr>
                        <th style="color: #284570; font-size: 8px; text-align: left; font-family: Montserrat;">User</th>
                        <th style="color: #284570; font-size: 8px; text-align: left; font-family: Montserrat;">Workflow</th>
                        <th style="color: #284570; font-size: 8px; text-align: left; font-family: Montserrat;">From Date</th>
                        <th style="color: #284570; font-size: 8px; text-align: left; font-family: Montserrat;">To Date</th>
                        <th style="color: #284570; font-size: 8px; text-align: left; font-family: Montserrat;">Delegate</th>
                    </tr>
                </thead>
               
                @foreach ($retrievedData as $data)
    @if ($data->emp_id == auth()->guard('emp')->user()->emp_id)
        <tr style="height:auto">
            <td style="border: 1px solid #8D939D; padding: 5px; font-size: 7px; font-family: Montserrat">
                {{ $data->first_name }} {{ $data->last_name }} ({{ $data->emp_id }})
            </td>
            <td style="border: 1px solid #8D939D; padding: 5px; font-size: 7px; font-family: Montserrat">{{ $data->workflow }}</td>
            <td style="border: 1px solid #8D939D; padding: 5px; font-size: 7px; font-family: Montserrat">{{ date('d M Y', strtotime($data->from_date)) }}</td>
            <td style="border: 1px solid #8D939D; padding: 5px; font-size: 7px; font-family: Montserrat">{{ date('d M Y', strtotime($data->to_date)) }}</td>
            <td style="border: 1px solid #8D939D; padding: 5px; font-size: 7px; font-family: Montserrat">{{ $data->delegate }}</td>
        </tr>
    @endif
@endforeach


   
   
         
</table>    
      </div>
      </div>
<div>
   
 
   
  <div id="delegate-form-container"  style="width: 250px;background:white;border:1px solid silver;border-radius:5px; height: 500px;">
 
<form wire:submit.prevent="submitForm"  style="margin-left:20px;font-size:10px">
                    <div class="form-group" style="margin-left:15px">
                        <h2 style="font-size:14px;margin-top:20px;"><b>Add/ Edit Work Flow Delegates:</b></h2>
                        <div class="column" style="display:flex;font-size:8px">
                            <h3 class="form-label" style="margin-top:30px;font-size:12px">User:</h3>
                            <p style="margin-left:-30px;font-size:12px;font-weight:400"> {{$employee->first_name}} {{$employee->last_name}}  ({{$employee->emp_id}})</p>
                        </div>
                    </div>
                    <div class="form-group" style="color: black;margin-top:-20px">
                        <label class="form-label" style="color: black;font-size:10px">WorkFlow</label>
                        <select name="workflow"class="form-control" style="width: 200px; color: black;font-size:10px" wire:model="workflow">
                            <option style="color: black;font-size:10px" value="Delegate All Workflow">Delegate All Workflow</option>
                            <option style="color: black;font-size:10px" value="Attendance Regularization">Attendance Regularization</option>
                            <option style="color: black;font-size:10px" value="Confirmation">Confirmation</option>
                            <option style="color: black;font-size:10px" value="Resignations">Resignations</option>
                            <option style="color: black;font-size:10px" value="Leave">Leave</option>
                            <option style="color: black;font-size:10px" value="Leave Cancel">Leave Cancel</option>
                            <option style="color: black;font-size:10px" value="Leave Comp Off">Leave Comp Off</option>
                            <option vstyle="color: black;font-size:10px" alue="Restricted Holiday Leave">Restricted Holiday Leave</option>
                            <option style="color: black;font-size:10px" value="Help Desk">Help Desk</option>
                            <!-- Add your workflow options here -->
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="form-label" style="font-size:10px">From Date</label>
                        @error('fromDate') <span>{{ $message }}</span> @enderror
                        <input type="date" name="fromDate" style="color: black;font-size:10px;width:200px" class="form-control" style="width: 280px" wire:model="fromDate">
                    </div>
                    <div class="form-group">
                        <label class="form-label" style="font-size:10px">To Date</label>
                        @error('toDate') <span>{{ $message }}</span> @enderror
                        <input type="date" style="color: black;font-size:10px;width:200px" name="toDate" class="form-control" style="width: 280px" wire:model="toDate">
                    </div>
                    <div class="form-group" style="color: black;font-size:10px">
                        <label class="form-label" style="font-size:10px">Delegate</label>
                        <select class="form-control" style="width: 200px;color: black;font-size:10px" wire:model="delegate">
                            <option style="color: black;font-size:10px" value="Pranita Priyadarshi(XSS-0477)">Pranita Priyadarshi(XSS-0477)</option>
                            <option style="color: black;font-size:10px" value="Chandrapal Singh(XSS-0468)">Chandrapal Singh(XSS-0468)</option>
                            <option style="color: black;font-size:10px" value="Puran Kanwar(T0008)">Puran Kanwar(T0008)</option>
                            <option style="color: black;font-size:10px" value="RANJITH KUMAR C(XSS-0386)">RANJITH KUMAR C(XSS-0386)</option>
                            <option style="color: black;font-size:10px" value="Sai Keerthan Enterprise(T00013)">Sai Keerthan Enterprise(T00013)</option>
                            <option style="color: black;font-size:10px" value="Hemant Parkhe(XSS-0509)">Hemant Parkhe(XSS-0509)</option>
                            <option style="color: black;font-size:10px" value="Indu Priya Yarramaneni(XSS-0438)">Indu Priya Yarramaneni(XSS-0438)</option>
                            <option style="color: black;font-size:10px"  value="Chirag Sahu(XSS-0506)">Chirag Sahu(XSS-0506)</option>
                            <option style="color: black;font-size:10px" value="Manish Vodnala(XSS-0522)">Manish Vodnala(XSS-0522)</option>
                            <!-- Add your delegate options here -->
                        </select>
                    </div>
                    <div class="form-actions">
                    <button class="btn btn-primary submit" type="submit" style="color: white; background:rgb(2, 17, 79);height:30px;font-size:12px">Submit</button>
                        <button id="cancel-button" class="btn reset" type="reset" style="color: white; background:rgb(2, 17, 79);height:30px;font-size:12px">Cancel</button>
                    </div>
                </form>
               
             
</div>

  </div>
      </div>
  @endforeach
</div>
   



    <script>
        document.getElementById('show-delegate-form-button').addEventListener('click', function () {
            var delegateFormContainer = document.getElementById('delegate-form-container');
            if (delegateFormContainer.style.display === 'none' || delegateFormContainer.style.display === '') {
                delegateFormContainer.style.display = 'block';
            } else {
                delegateFormContainer.style.display = 'none';
            }
        });
 
        document.getElementById('cancel-button').addEventListener('click', function () {
            var delegateFormContainer = document.getElementById('delegate-form-container');
            delegateFormContainer.style.display = 'none';
        });
    </script>
    
</body>
</html>
 
</div>
</div>
