<div class="container-it" style="width:90%;">
@if ($salaryRevision->isEmpty())
<div style="align-items:center;justify-content:center;">
<div class="homeCard6" style="width:80%;justify-content:center;align-items:center">
                            <div class="py-2 px-3" style="height:400px;justify-content:center">
                                <div class="d-flex justify-content-center">
                                    <p style="font-size:20px;color:#778899;font-weight:500;align-items:center">IT Statements</p>
                                    
                                </div>

                                <div style="display:flex;align-items:center;flex-direction:column;">
                                        <img src="https://th.bing.com/th/id/OIP.pdoKODCp_FelHFj7crhbCwHaEK?w=316&h=180&c=7&r=0&o=5&dpr=1.5&pid=1.7" alt="" style="height:300px;width:300px;">
                                    <p style="color: #677A8E;  margin-bottom: 20px; font-size:12px;"> We are currently working on your IT Statements!</p>
                                </div>
                            </div>
                        </div>
                        </div>
@else
    <div>
        <div class="d-flex justify-content-end">
            <button onclick="window.location.href='/itform'" id="pdfLink2023_4" class="pdf-download btn-primary px-3 rounded ml-9" download style="display: inline-block;background:rgb(2, 17, 79);"><i class="fas fa-download"></i></button>
        </div>
        <div class="row p-0 mb-5 text-center m-0 d-flex align-items-center" style="margin: 0 auto;">
            <div class="col-md-2 p-0 ml-2 mr-1 bg-white mb-3 mb-md-0" style="height:100px; border-radius: 5px;border:1px solid silver">
                <p style="font-size:10px;color:#778899;margin-top:5px">TAX CALCULATED AS PER</p>
                <div style="padding:0;border-bottom:1px solid #ccc;margin-bottom:7px;"></div>
                <p style="font-size:12px;color:#41CD2A;">NEW TAX REGIME</p>
           </div>
            <div class="col-md-2 p-0 ml-2 mr-1 bg-white mb-3 mb-md-0" style="height:100px; border-radius: 5px;border:1px solid silver">
                <p style="font-size:10px;color:#778899;margin-top:5px">NET TAX IN ₹</p>
                <div style="padding:0;border-bottom:1px solid #ccc;margin-bottom:7px;"></div>
                <strong style="font-size:15px;">0.00</strong>
           </div>
            <div class="col-md-2 p-0 ml-2 mr-1 bg-white mb-3 mb-md-0" style="height:100px; border-radius: 5px;border:1px solid silver">
                <p style="font-size:10px;color:#778899;margin-top:5px">TOTAL TAX DUE IN ₹</p>
                <div style="padding:0;border-bottom:1px solid #ccc;margin-bottom:7px;"></div>
                <strong style="font-size:15px;">0.00</strong>
           </div>
            <div class="col-md-3 p-0 ml-2 mr-1 bg-white mb-3 mb-md-0" style="height:100px; border-radius: 5px;border:1px solid silver">
                <p style="font-size:10px;color:#778899;margin-top:5px">TAX DEDUCTIBLE PER MONTH IN ₹</p>
                <div style="padding:0;border-bottom:1px solid #ccc;margin-bottom:7px;"></div>
                <strong style="font-size:15px;">0.00</strong>

            </div>

       
        </div>
        @foreach($salaryRevision as $employee)
        
        <div _ngcontent-ffh-c446="" class="expand-collapse" style="width: 150px; height: 50px;position: relative;">
            <button id="collapseExpandBtn" _ngcontent-ffh-c446="" class="btn btn-link ng-star-inserted" onfocus="this.blur()"><p  style="margin-top:10px">Expand all</p></button>
        </div>
        <div class="d-flex justify-content-end">
           <p style="text-align:end;margin-top: -40px;white-space: nowrap;">Value in ₹</p>
        </div>
        <div class="row bg-white ml-2">

            <div class="col-md-12 bg-white d-flex text-center  " style="height:50px; border-radius:2px;border:1px solid silver">
                <p id="expandButton" class="mt-3" style="font-size: 14px;">+</p>
                <span class="mt-3 mx-3" style="font-size:14px ">A. Income </span>
                <span class="mt-3 ml-auto">₹{{ number_format($employee->calculateTotalAllowance()*12, 2) }}</span>
            </div>
        </div>
        <div id="incomeContainers" class="income-containers" style="display: none;" >
          <div class="row">
              <div class="col-md-12 mt-2 ml-2" style="width:500px;">
                  <div class="table-responsive">
                      <table class="income-table" style="width:500px;font-size:7px;">
                         <tr class="table-header" style="color:white;font-weight:normal;font-size:10px;background:rgb(2, 17, 79);height:40px;width:500px;color:white;">
                                <th class="item-header pl-3">Items</th>
                                <th class="item-header">Total</th>
                                <th class="item-header">Jan 2023</th>
                                <th class="item-header">Feb 2023</th>
                                <th class="item-header">Mar 2023</th>
                                <th class="item-header">Apr 2023</th>
                                <th class="item-header">May 2023</th>
                                <th class="item-header">Jun 2023</th>
                                <th class="item-header">Jul 2023</th>
                                <th class="item-header">Aug 2023</th>
                                <th class="item-header">Sep 2023</th>
                                <th class="item-header">Oct 2023</th>
                                <th class="item-header">Nov 2023</th>
                                <th class="item-header">Dec 2023</th>
                           </tr>
                          <tbody class="table-body" style="width:500px;color:black;background:white;font-size:8px;">
                             <tr class="table-row" style="width:500px;">
                                    <td class="item-name" style="font-size:11px"><b>Basic</b></td>
                                    <td class="item-value" style="font-size:11px">{{ number_format($employee->basic*12, 2) }}</td>
                                    <td class="item-value" style="font-size:11px">{{ number_format($employee->basic, 2) }}</td>
                                    <td class="item-value" style="font-size:11px">{{ number_format($employee->basic, 2) }}</td>
                                    <td class="item-value" style="font-size:11px">{{ number_format($employee->basic, 2) }}</td>
                                    <td class="item-value" style="font-size:11px">{{ number_format($employee->basic, 2) }}</td>
                                    <td class="item-value" style="font-size:11px">{{ number_format($employee->basic, 2) }}</td>
                                    <td class="item-value" style="font-size:11px">{{ number_format($employee->basic, 2) }}</td>
                                    <td class="item-value" style="font-size:11px">{{ number_format($employee->basic, 2) }}</td>
                                    <td class="item-value" style="font-size:11px">{{ number_format($employee->basic, 2) }}</td>
                                    <td class="item-value" style="font-size:11px">{{ number_format($employee->basic, 2) }}</td>
                                    <td class="item-value" style="font-size:11px">{{ number_format($employee->basic, 2) }}</td>
                                    <td class="item-value" style="font-size:11px">{{ number_format($employee->basic, 2) }}</td>
                                    <td class="item-value" style="font-size:11px">{{ number_format($employee->basic, 2) }}</td>
                                </tr>
                                <tr class="table-row" style="width:500px;color:black;background:white">
                                    <td class="item-name" style="font-size:11px"><b>HRA</b></td>
                                    <td class="item-value" style="font-size:11px">{{ number_format($employee->hra*12, 2) }}</td>
                                    <td class="item-value" style="font-size:11px">{{ number_format($employee->hra, 2) }}</td>
                                    <td class="item-value" style="font-size:11px">{{ number_format($employee->hra, 2) }}</td>
                                    <td class="item-value" style="font-size:11px">{{ number_format($employee->hra, 2) }}</td>
                                    <td class="item-value" style="font-size:11px">{{ number_format($employee->hra, 2) }}</td>
                                    <td class="item-value" style="font-size:11px">{{ number_format($employee->hra, 2) }}</td>
                                    <td class="item-value" style="font-size:11px">{{ number_format($employee->hra, 2) }}</td>
                                    <td class="item-value" style="font-size:11px">{{ number_format($employee->hra, 2) }}</td>
                                    <td class="item-value" style="font-size:11px">{{ number_format($employee->hra, 2) }}</td>
                                    <td class="item-value" style="font-size:11px">{{ number_format($employee->hra, 2) }}</td>
                                    <td class="item-value" style="font-size:11px">{{ number_format($employee->hra, 2) }}</td>
                                    <td class="item-value" style="font-size:11px">{{ number_format($employee->hra, 2) }}</td>
                                    <td class="item-value" style="font-size:11px">{{ number_format($employee->hra, 2) }}</td>
                                </tr>
                                <tr  class="table-row" style="width:500px;color:black;background:white">
                                    <td class="item-name" style="font-size:11px"><b>Conveyance</b></td>
                                    <td class="item-value" style="font-size:11px">{{ number_format($employee->conveyance*12, 2) }}</td>
                                    <td class="item-value" style="font-size:11px">{{ number_format($employee->conveyance, 2) }}</td>
                                    <td class="item-value" style="font-size:11px">{{ number_format($employee->conveyance, 2) }}</td>
                                    <td class="item-value" style="font-size:11px">{{ number_format($employee->conveyance, 2) }}</td>
                                    <td class="item-value" style="font-size:11px">{{ number_format($employee->conveyance, 2) }}</td>
                                    <td class="item-value" style="font-size:11px">{{ number_format($employee->conveyance, 2) }}</td>
                                    <td class="item-value" style="font-size:11px">{{ number_format($employee->conveyance, 2) }}</td>
                                    <td class="item-value" style="font-size:11px">{{ number_format($employee->conveyance, 2) }}</td>
                                    <td class="item-value" style="font-size:11px">{{ number_format($employee->conveyance, 2) }}</td>
                                    <td class="item-value" style="font-size:11px">{{ number_format($employee->conveyance, 2) }}</td>
                                    <td class="item-value" style="font-size:11px">{{ number_format($employee->conveyance, 2) }}</td>
                                    <td class="item-value" style="font-size:11px">{{ number_format($employee->conveyance, 2) }}</td>
                                    <td class="item-value" style="font-size:11px">{{ number_format($employee->conveyance, 2) }}</td>
                                </tr>
                                <tr  class="table-row" style="width:500px;color:black;background:white">
                                    <td class="item-name" style="font-size:11px"><b>Medical</b></td>
                                    <td class="item-value" style="font-size:11px">{{ number_format($employee->medical*12, 2) }}</td>
                                    <td class="item-value" style="font-size:11px">{{ number_format($employee->medical, 2) }}</td>
                                    <td class="item-value" style="font-size:11px">{{ number_format($employee->medical, 2) }}</td>
                                    <td class="item-value" style="font-size:11px">{{ number_format($employee->medical, 2) }}</td>
                                    <td class="item-value" style="font-size:11px">{{ number_format($employee->medical, 2) }}</td>
                                    <td class="item-value" style="font-size:11px">{{ number_format($employee->medical, 2) }}</td>
                                    <td class="item-value" style="font-size:11px">{{ number_format($employee->medical, 2) }}</td>
                                    <td class="item-value" style="font-size:11px">{{ number_format($employee->medical, 2) }}</td>
                                    <td class="item-value" style="font-size:11px">{{ number_format($employee->medical, 2) }}</td>
                                    <td class="item-value" style="font-size:11px">{{ number_format($employee->medical, 2) }}</td>
                                    <td class="item-value" style="font-size:11px">{{ number_format($employee->medical, 2) }}</td>
                                    <td class="item-value" style="font-size:11px">{{ number_format($employee->medical, 2) }}</td>
                                    <td class="item-value" style="font-size:11px">{{ number_format($employee->medical, 2) }}</td>
                                </tr>
                                <tr  class="table-row" style="width:500px;color:black;background:white;">
                                    <td class="item-name" style="font-size:11px"><b>Special Allowance</b></td>
                                    <td class="item-value" style="font-size:11px">{{ number_format($employee->special*12, 2) }}</td>
                                    <td class="item-value" style="font-size:11px">{{ number_format($employee->special, 2) }}</td>
                                    <td class="item-value" style="font-size:11px">{{ number_format($employee->special, 2) }}</td>
                                    <td class="item-value" style="font-size:11px">{{ number_format($employee->special, 2) }}</td>
                                    <td class="item-value" style="font-size:11px">{{ number_format($employee->special, 2) }}</td>
                                    <td class="item-value" style="font-size:11px">{{ number_format($employee->special, 2) }}</td>
                                    <td class="item-value" style="font-size:11px">{{ number_format($employee->special, 2) }}</td>
                                    <td class="item-value" style="font-size:11px">{{ number_format($employee->special, 2) }}</td>
                                    <td class="item-value" style="font-size:11px">{{ number_format($employee->special, 2) }}</td>
                                    <td class="item-value" style="font-size:11px">{{ number_format($employee->special, 2) }}</td>
                                    <td class="item-value" style="font-size:11px">{{ number_format($employee->special, 2) }}</td>
                                    <td class="item-value" style="font-size:11px">{{ number_format($employee->special, 2) }}</td>
                                    <td class="item-value" style="font-size:11px">{{ number_format($employee->special, 2) }}</td>
                                </tr>
                                <tr  class="table-row" style="width:500px;color:black;background:white;font-size:10px">
                                    <td class="item-name" style="font-size:11px"><b>Total Allowance</b></td>
                                    <td class="item-value"  style="font-size:11px">{{ number_format($employee->calculateTotalAllowance()*12, 2) }}</td>
                                    <td class="item-value" style="font-size:11px">{{ number_format($employee->calculateTotalAllowance(), 2) }}</td>
                                    <td class="item-value" style="font-size:11px">{{ number_format($employee->calculateTotalAllowance(), 2) }}</td>
                                    <td class="item-value" style="font-size:11px">{{ number_format($employee->calculateTotalAllowance(), 2) }}</td>
                                    <td class="item-value" style="font-size:11px">{{ number_format($employee->calculateTotalAllowance(), 2) }}</td>
                                    <td class="item-value" style="font-size:11px">{{ number_format($employee->calculateTotalAllowance(), 2) }}</td>
                                    <td class="item-value" style="font-size:11px">{{ number_format($employee->calculateTotalAllowance(), 2) }}</td>
                                    <td class="item-value" style="font-size:11px">{{ number_format($employee->calculateTotalAllowance(), 2) }}</td>
                                    <td class="item-value" style="font-size:11px">{{ number_format($employee->calculateTotalAllowance(), 2) }}</td>
                                    <td class="item-value" style="font-size:11px">{{ number_format($employee->calculateTotalAllowance(), 2) }}</td>
                                    <td class="item-value" style="font-size:11px">{{ number_format($employee->calculateTotalAllowance(), 2) }}</td>
                                    <td class="item-value" style="font-size:11px">{{ number_format($employee->calculateTotalAllowance(), 2) }}</td>
                                    <td class="item-value" style="font-size:11px">{{ number_format($employee->calculateTotalAllowance(), 2) }}</td>
                                </tr>
                                <!-- Add more rows as needed -->
                            </tbody>
                        </table>
                   </div>
               </div>

            </div>

         @endforeach

        </div>
        <div class="row bg-white ml-2 mt-3">

           <div class="col-md-12 bg-white d-flex text-center  " style="height:50px; border-radius:2px;border:1px solid silver;">
              <p id="expandButton2" class="mt-3" style="font-size: 14px;">+</p>
              <span class="mt-3 mx-3" style="font-size:14px ">B.Deductions </span>
              <span class="mt-3 ml-auto">₹{{ number_format($employee->calculatePf() * 12 + 1800, 2) }}</span>
          </div>
       </div>
       <div id="incomeContainer2" class="income-container2" style="display: none;" >
          <div class="row m-0 p-0" >
              <div class="col-md-12 mt-2 ml-2" style="width:500px;">
              <div class="table-responsive">
                  <table class="income-table " style="width:500px;">
                        <tr class="table-header" style="color:white;font-weight:normal;font-size:10px;background:rgb(2, 17, 79);height:40px;width:500px;color:white;">
                            <th class="item-header pl-3">Items</th>
                            <th class="item-header">Total</th>
                            <th class="item-header">Jan 2023</th>
                            <th class="item-header">Feb 2023</th>
                            <th class="item-header">Mar 2023</th>
                            <th class="item-header">Apr 2023</th>
                            <th class="item-header">May 2023</th>
                            <th class="item-header">Jun 2023</th>
                            <th class="item-header">Jul 2023</th>
                            <th class="item-header">Aug 2023</th>
                            <th class="item-header">Sep 2023</th>
                            <th class="item-header">Oct 2023</th>
                            <th class="item-header">Nov 2023</th>
                            <th class="item-header">Dec 2023</th>
                        </tr>
                       <tbody class="table-body" style="width:500px;color:black;background:white">
                            <tr class="table-row">
                                <td class="item-name"><b>PF</b></td>
                                <td class="item-value">{{ number_format($employee->calculatePf()*12, 2) }}</td>
                                <td class="item-value">{{ number_format($employee->calculatePf(), 2) }}</td>
                                <td class="item-value">{{ number_format($employee->calculatePf(), 2) }}</td> 
                                <td class="item-value">{{ number_format($employee->calculatePf(), 2) }}</td>
                                <td class="item-value">{{ number_format($employee->calculatePf(), 2) }}</td>
                                <td class="item-value">{{ number_format($employee->calculatePf(), 2) }}</td>
                                <td class="item-value">{{ number_format($employee->calculatePf(), 2) }}</td>
                                <td class="item-value">{{ number_format($employee->calculatePf(), 2) }}</td>
                                <td class="item-value">{{ number_format($employee->calculatePf(), 2) }}</td>
                                <td class="item-value">{{ number_format($employee->calculatePf(), 2) }}</td>
                                <td class="item-value">{{ number_format($employee->calculatePf(), 2) }}</td>
                                <td class="item-value">{{ number_format($employee->calculatePf(), 2) }}</td>
                                <td class="item-value">{{ number_format($employee->calculatePf(), 2) }}</td>
                            </tr>
                            <tr class="table-row" style="width:500px;color:black;background:white">
                                <td class="item-name"><b>PROTAX</b></td>
                                <td class="item-value">1800.00</td>
                                <td class="item-value">150.00</td>
                                <td class="item-value">150.00</td>
                                <td class="item-value">150.00</td>
                                <td class="item-value">150.00</td>
                                <td class="item-value">150.00</td>
                                <td class="item-value">150.00</td>
                                <td class="item-value">150.00</td>
                                <td class="item-value">150.00</td>
                                <td class="item-value">150.00</td>
                                <td class="item-value">150.00</td>
                                <td class="item-value">150.00</td>
                                <td class="item-value">150.00</td>
                            </tr>
                            <tr class="table-row" style="width:500px;color:black;background:white">
                                <td class="item-name"><b>Total</b></td>
                                <td class="item-value">{{ number_format($employee->calculatePf()+150*12, 2) }}</td>
                                <td class="item-value">{{ number_format($employee->calculatePf() + 150, 2) }}</td>
                                <td class="item-value">{{ number_format($employee->calculatePf() + 150, 2) }}</td>
                                <td class="item-value">{{ number_format($employee->calculatePf() + 150, 2) }}</td>
                                <td class="item-value">{{ number_format($employee->calculatePf() + 150, 2) }}</td>
                                <td class="item-value">{{ number_format($employee->calculatePf() + 150, 2) }}</td>
                                <td class="item-value">{{ number_format($employee->calculatePf() + 150, 2) }}</td>
                                <td class="item-value">{{ number_format($employee->calculatePf() + 150, 2) }}</td>
                                <td class="item-value">{{ number_format($employee->calculatePf() + 150, 2) }}</td>
                                <td class="item-value">{{ number_format($employee->calculatePf() + 150, 2) }}</td>
                                <td class="item-value">{{ number_format($employee->calculatePf() + 150, 2) }}</td>
                                <td class="item-value">{{ number_format($employee->calculatePf() + 150, 2) }}</td>
                                <td class="item-value">{{ number_format($employee->calculatePf() + 150, 2) }}</td>
                            </tr>
                                
                        </tbody>
                   </table>
              </div>
               </div>
           </div>
       </div>
       <div class="col-md-12 bg-white d-flex text-center mt-3 ml-1" style="height:50px; border-radius:2px;border:1px solid silver">
            <p id="expandButton3" class="mt-3" style="font-size: 14px;">+</p>
            <span class="mt-3 mx-3" style="font-size:14px ">C. Perquisites </span>
            <span class="mt-3 ml-auto">₹0.00</span>
        </div>
       
        <div id="incomeContainer3" class="income-container3"  style="display: none;">
            <div class="row">
                <div class="col-md-12 mt-2 ml-2 text-center bg-white  justify-content-center ">
            
                  <p  class="pt-2" style="height:40px;background:white">No data to display !!!</p>
                       
                   
                </div>
            </div>
        </div>

        <div class="col-md-12 bg-white d-flex text-center mt-3 ml-1" style="height:50px; border-radius:2px;border:1px solid silver">
            <p id="expandButton4" class="mt-3" style="font-size: 14px;">+</p>
            <span class="mt-3 mx-3" style="font-size:14px ">D. Income Excluded From Tax</span>
            <span class="mt-3 ml-auto">₹0.00</span>
        </div>
       
        <div id="incomeContainer4" class="income-container4"  style="display: none;">
          <div class="row">
                <div class="col-md-12 mt-2 ml-2 text-center bg-white  justify-content-center ">
    
                  <p  class="pt-2" style="height:40px;background:white">No data to display !!!</p>
                       
                   
                </div>

            </div>
        </div>
        <div class="col-md-12 mt-4 m-l-2 d-flex" style="height:40px; border-radius:2px;border:1px solid silver;background:rgb(2, 17, 79);color:white">
            <b class="pt-2">E. Gross Salary (A + C - D)</b>
            <span class="ml-auto pt-2">₹{{ number_format($employee->calculateTotalAllowance() * 12, 2) }}</span>
        </div>

        <div class="row bg-white ml-2 mt-3">

           <div class="col-md-12 bg-white d-flex text-center  " style="height:50px; border-radius:2px;border:1px solid silver">
                <p id="expandButton5" class="mt-3" style="font-size: 14px;">+</p>
                <span class="mt-3 mx-3" style="font-size:14px ">G. Income From Previous Employer </span>
                <span class="mt-3 ml-auto">₹0.00</span>
            </div>
        </div>
        <div id="incomeContainer5" class="income-container5" style="display: none;" >
          <div class="row">
              <div class="col-md-12 mt-2 ml-2">
                  <table class="income-table justify-content-spacebetween" style="width:100%">
                       <tr class="table-header" style="color:white;font-weight:normal;font-size:12px;background:rgb(2, 17, 79);height:40px;width:100%;color:white;">
                            <th class="item-header pl-3 text-start">Items</th>
                            <th class="item-header">Total</th>
        
                        </tr>
                        <tbody class="table-body" style="width:100%;color:black;background:white">
                            <tr class="table-row">
                                <td class="item-name text-start ml-4">TOTAL INCOME</td>
                                <td class="item-value">₹0.00</td>
                            
                            </tr>
                            <tr class="table-row" style="width:100%;color:black;background:white">
                                <td class="item-name text-start ml-4">INCOME TAX</td>
                                <td class="item-value">₹0.00</td>
                            
                            </tr>
                            <tr class="table-row" style="width:100%;color:black;background:white">
                                <td class="item-name text-start ml4">PROFESSIONAL TAX</td>
                                <td class="item-value">₹0.00</td>
                                
                            </tr>
                            <tr class="table-row" style="width:100%;color:black;background:white">
                                <td class="item-name  text-start ml-4">PROVIDENT FUND</td>
                                <td class="item-value">₹0.00</td>
                                
                            </tr>
                    
                        </tbody>
                   </table>
                </div>
            </div>
       </div>


    </div>
@endif
<script>
    function toggleVisibility(buttonId, containerId) {
        const button = document.getElementById(buttonId);
        const container = document.getElementById(containerId);
 
        button.addEventListener('click', function () {
            if (container.style.display === 'none' || container.style.display === '') {
                container.style.display = 'block';
                button.textContent = '-';
            } else {
                container.style.display = 'none';
                button.textContent = '+';
            }
        });
    }
 
    // Call the function for each button-container pair
    toggleVisibility('expandButton', 'incomeContainers');
    toggleVisibility('expandButton2', 'incomeContainer2');
    toggleVisibility('expandButton3', 'incomeContainer3');
    toggleVisibility('expandButton4', 'incomeContainer4');
    toggleVisibility('expandButton5', 'incomeContainer5');



    collapseExpandBtn.addEventListener('click', function() {
    if (collapseExpandBtn.textContent === 'Expand all') {
        collapseExpandBtn.textContent = 'Collapse all';
        // Implement the logic to expand all here
        //row---->1
        const expandBtn = document.getElementById('expandButton');
        const incmContainers = document.getElementById('incomeContainers');
        if (incmContainers.style.display === 'none' || incmContainers.style.display === '') {
            incmContainers.style.display = 'block';
            expandBtn.textContent = '-';
        }
        //row---->2
        const expandBtn2 = document.getElementById('expandButton2');
        const incmContainer2 = document.getElementById('incomeContainer2');
        if (incmContainer2.style.display === 'none' || incmContainer2.style.display === '') {
            incmContainer2.style.display = 'block';
                expandBtn2.textContent = '-';
        }
        //row---->3
        const expandBtn3 = document.getElementById('expandButton3');
        const incmContainer3 = document.getElementById('incomeContainer3');
        if (incmContainer3.style.display === 'none' || incmContainer3.style.display === '') {
            incmContainer3.style.display = 'block';
                expandBtn3.textContent = '-';
        }
    //row---->4
        const expandBtn4 = document.getElementById('expandButton4');
        const incmContainer4 = document.getElementById('incomeContainer4');
        if (incmContainer4.style.display === 'none' || incmContainer4.style.display === '') {
            incmContainer4.style.display = 'block';
                expandBtn4.textContent = '-';
        }
        //row---->5
        const expandBtn5 = document.getElementById('expandButton5');
        const incmContainer5 = document.getElementById('incomeContainer5');
        if (incmContainer5.style.display === 'none' || incmContainer5.style.display === '') {
            incmContainer5.style.display = 'block';
            expandBtn5.textContent = '-';
        }
    }
    else {
        collapseExpandBtn.textContent = 'Expand all';
        // Implement the logic to collapse all here
        //row--->1
        const expandBtn = document.getElementById('expandButton');
        const incmContainers = document.getElementById('incomeContainers');
        incmContainers.style.display = 'none';
        expandBtn.textContent = '+';
        //row--->2
        const expandBtn2 = document.getElementById('expandButton2');
        const incmContainer2 = document.getElementById('incomeContainer2');
        incmContainer2.style.display = 'none';
        expandBtn2.textContent = '+';
        //row--->3
        const expandBtn3 = document.getElementById('expandButton3');
        const incmContainer3 = document.getElementById('incomeContainer3');
        incmContainer3.style.display = 'none';
        expandBtn3.textContent = '+';
        //row--->4
        const expandBtn4 = document.getElementById('expandButton4');
        const incmContainer4 = document.getElementById('incomeContainer4');
        incmContainer4.style.display = 'none';
        expandBtn4.textContent = '+';
        //row--->5
        const expandBtn5 = document.getElementById('expandButton5');
        const incmContainer5 = document.getElementById('incomeContainer5');
        incmContainer5.style.display = 'none';
        expandBtn5.textContent = '+';
    }
    });
</script>
