<div>
    <div class="container-b">
        <div class="row" style="display:flex">
     
       <div class="N" style="margin-left:10px;position: relative;">
       <a href="/itdeclaration" class="cus-button" style="width: 150px; display: inline-block; padding: 10px 20px; background-color: #5394ec; color: white; text-align: center; text-decoration: none; border: 1px solid silver; border-radius: 5px;  margin-left: 600px; margin-bottom: 50px; height: 40px; ">
       <p style="text-align: center; margin-top: 0px; font-size:12px;">My Tax Planner</p>
</a>
 
 

       <div class="container-A" style="margin-top:-80px;margin-right:100px">
            <div class="row">
                <div class="col-md-12 text-right">
                    <select id="yearSelect" style="padding: 5px; border: 1px solid #ccc;border-radius: 5px;font-size: 16px;background-color: #fff;
                 color: #333;cursor: pointer; width: 150px;">
                        <option class="dropdown" value="2023">2023</option>
                        <option class="dropdown" value="2024" selected>2024</option>
                    </select>
                </div>
            </div>
        </div>
<div>
<div class="container-b" style="display:flex">
<div class="container-A" style="width:500px;height:300px;background:white;border:1px solid silver;border-radius:5px;margin-top:20px;margin-left:10px;">
 
<img src="https://th.bing.com/th/id/OIP.vwV51NMNZ8YgCdZ__BSFkQAAAA?pid=ImgDet&rs=1" style="height:80px;width:100px;margin-top:80px;margin-left:180px">
<p style="margin-left:150px;color:#ACADAA;margin-top:20px">Sigh! Declaration is locked</p>
<p style="margin-left:80px;color:#ACADAA;font-size:12px">This declaration window is locked. Please wait for the admin notification</p>
    </div>  
<div class="A" style="margin-left:15px" >
    <div class="row" style="width:300px;height:100px;background:#FBF5BF;border:1px solid silver;border-radius:5px;margin-top:20px;margin-left:5px;display:flex">
    <div class="column" style="display:flex">
    <p style="margin-left:-10px">Declaration Status : LOCKED</p>
 
    </div>
   
<p id="last-date-paragraph" style="font-size:14px">You have declared on <span id="declaration-date"></span>, and you cannot withdraw it</p>
    </div>
    <div class="row" style="width:300px;height:70px;background:white;border:1px solid silver;border-radius:5px;margin-top:10px;margin-left:5px;display:flex">
   
    <p style="font-size:14px;margin-top:10px">Your IT declaration is considered as per the New Regime</p>
    </div>
    <a href="/downloadform" id="pdfLink2023_4" class="downloadform" download style="margin-left: 10px; display: inline-block;">Download Form 12BB</a>
 
 
</div>
    </div>
 
  </div>
</div>
 
   
    </div>
    <script>
    // Get current date
    var currentDate = new Date();
 
    // Get the first day of the current month
    var firstDayOfMonth = new Date(currentDate.getFullYear(), currentDate.getMonth(), 2);
 
    // Calculate the last day of the previous month
    var lastDayOfPreviousMonth = new Date(firstDayOfMonth - 2).getDate();
 
    // Get the month and year of the previous month
    var previousMonth = firstDayOfMonth.getMonth();
    var previousYear = firstDayOfMonth.getFullYear();
 
    // Format the previous month and year nicely
    var formattedPreviousMonth = new Intl.DateTimeFormat('en-US', { month: 'long' }).format(new Date(previousYear, previousMonth));
 
    // Update the paragraph text with the last date of the previous month
    var paragraph = document.getElementById("last-date-paragraph");
    paragraph.innerHTML = "You have declared on " + lastDayOfPreviousMonth + " " + formattedPreviousMonth + " " + previousYear + ", and you cannot withdraw it";
</script>
