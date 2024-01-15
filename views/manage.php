<?php  
    if(!isset($_SESSION['loggedmail'])) {
    echo'<script>';
    echo 'location.href="./logout"';
    echo'</script>';
    die();
}
?>
<?php $this->layout("layout-base"); ?>
<style media="screen">
      input[type=checkbox]
      {
        -ms-transform: scale(1.5); /* IE */
        -webkit-transform: scale(1.5); /* Safari and Chrome */ 
        padding: 10px;
      }
</style>

<div class="container">
	<h3>การจัดการอนุมัติจองรถ</h3>
	<button class="btn btn-primary" id="manage">จัดการ</button>
    <button class="btn btn-default" id="cancel">ยกเลิก</button>   
    <br><br>
	<div id="grid"></div>
    <br><hr>
    <h3>รายการที่จัดการจองรถแล้ว</h3>
    <button class="btn btn-primary" id="send" disabled>ส่ง</button>
    <!-- <button class="btn btn-primary" id="edit" disabled>แก้ไข</button> -->
    <button class="btn btn-default" id="canceled" disabled>ยกเลิก</button>  
    <button class="btn btn-primary" id="add_request">เพิ่มรายการ</button>
    <br><br>
    <div id="gridtrans"></div>
</div>

<div id="dialogdetail"> 
         <div><h5><p id="demo"></p></h5></div>
         <div>
            <table class="table table-striped table-hover" width="100%">
              <tbody>
                <tr>
                  <td width="25%"><h5><b>ต้นทาง</b></h5></td>
                  <td width="25%"><h5><p id="start"></p></h5></td>
                  <td width="25%"><h5><b>จุดขึ้นรถ</b></h5></td>
                  <td width="25%"><h5><p id="point"></p></h5></td>
                </tr>
                <tr>
                  <td><h5><b>ปลายทาง</b></h5></td>
                  <td><h5><p id="finish"></p></h5></td>
                  <td></td>
                  <td></td>
                </tr>
                <tr>
                  <td><h5><b>วันที่ออกเดินทาง</b></h5></td>
                  <td><h5><p id="date_st"></p></h5></td>
                  <td><h5><b>เวลาเริ่ม</b></h5></td>
                  <td><h5><p id="time_st"></p></h5></td>
                </tr>
                <tr>
                  <td><h5><b>วันที่เดินทางมาถึง</b></h5></td>
                  <td><h5><p id="date_en"></p></h5></td>
                  <td><h5><b>เวลาสิ้นสุด</b></h5></td>
                  <td><h5><p id="time_en"></p></h5></td>
                </tr>
                <tr>
                  <td><h5><b>จำนวนผู้โดยสาร</b></h5></td>
                  <td><h5><p id="seatt"></p></h5></td>
                  <td></td>
                  <td></td>
                </tr>
                <tr>
                  <td><h5><b>จุดประะสงค์การใช้รถ</b></h5></td>
                  <td colspan="3"><h5><p id="titlee"></p></h5></td>
                </tr>
                <tr>
                  <td><h5><b>สร้างโดย</b></h5></td>
                  <td colspan="3"><h5><p id="createbyy"></p></h5></td>
                </tr>
                <tr>
                  <td><h5><b>อนุมัติโดย</b></h5></td>
                  <td colspan="3"><h5><p id="mgbyy"></p></h5></td>
                </tr>
                <!-- <tr>
                   <td><h5><b>ไฟล์แนบ</b></h5></td>
                   <td colspan="3"><h5><p id="linkmy"></p></h5></td>
                </tr> -->
              </tbody>
            </table>
         </div>
</div>

<div id="dialogcar"> 
             <div>SelectCar</div>
             <div id="carform"></div>
</div>
<div id="dialogdriver"> 
             <div>SelectDriver</div>
             <div id="driverform"></div>
</div>

<div id="dialogecar"> 
             <div>SelectCar</div>
             <div id="ecarform"></div>
</div>
<div id="dialogedriver"> 
             <div>SelectDriver</div>
             <div id="edriverform"></div>
</div>

<div id="dialogmanage">
        <div><strong>ManageCar</strong></div>
        <div>
        <form id="managefrom" class="form-horizontal">
            <table>  
            <tr>
                <td>
                    <div class="col-sm-16">
                    	<label>เลือกรถ</label>
                	</div>
                </td>
                <td>
                    <div class="col-sm-12">
                        <input type="hidden" name="carid" id="carid">
                    	<input type="textbox" class="form-control"  name="carname" id="carname" readonly>
                	</div>
                </td>
                <td>
                	<button class="btn btn-primary" type="button" id="selectcar">click</button> 
                </td>
                 <td>
                    <div class="col-sm-16">
                    	<label>&nbsp;&nbsp;&nbsp;เลือกพนักงานขับ</label>
                	</div>
                </td>
                <td>
                    <div class="col-sm-12">
                        <input type="hidden" name="driverid" id="driverid">
                    	<input type="textbox" class="form-control"  name="drivername" id="drivername" readonly>
                	</div>
                </td>
                <td>
                	<button class="btn btn-primary" type="button" id="selectdriver">click</button> 
                </td>
            </tr>
            <tr>
            	<td colspan="6">
                	<div class="col-sm-12"><br></div>
            	</td>
            </tr>
            <tr>
                <td>
                    <div class="col-sm-16">
                    	<label>วันที่ใช้รถ</label>
                	</div>
                </td>
                <td colspan="2">
                    <div class="col-xs-9">
                        <div id='datestart'>
                        <!-- <div class="input-group input-append date" id="startDatePicker">
                            <input type="text" class="form-control" id="startDate" />
                            <span class="input-group-addon add-on">
                            <span class="glyphicon glyphicon-calendar"></span>
                            </span>
                        </div> -->
                    </div>
                </td>
                <td>
                	<div class="col-sm-16">
                    	<label>&nbsp;&nbsp;&nbsp;เวลารถออก</label>
                	</div>
                </td>
                <td>
                    <div class="col-xs-9">
                        <input type="text" class="form-control" name="startTime" id="startTime"/>
                    </div>
                </td>
            </tr>
            <tr>
            	<td colspan="6">
                	<div class="col-sm-12"><br></div>
            	</td>
            </tr>
            <tr>
                <td>
                    <div class="col-sm-16">
                    	<label>ใช้รถถึงวันที่</label>
                	</div>
                </td>
                <td colspan="2">
                    <div class="col-xs-9">
                       <!--  <div class="input-group input-append date" id="endDatePicker">
                            <input type="text" class="form-control" name="endDate" id="endDate"/>
                            <span class="input-group-addon add-on">
                            <span class="glyphicon glyphicon-calendar"></span>
                            </span>
                        </div> -->
                        <div id='dateend'>
                    </div>
                </td>
                <td>
                	<div class="col-sm-16">
                    	<label>&nbsp;&nbsp;&nbsp;เวลารถกลับ</label>
                	</div>
                </td>
                <td>
                    <div class="col-xs-9">
                        <input type="text" class="form-control" name="endTime" id="endTime"/>
                    </div>
                </td>
            </tr>
            <tr>
                <td colspan="6">
                    <div class="col-sm-12"><br></div>
                </td>
            </tr>
            <tr>
                <td>
                    <div class="col-sm-16">
                        <label>จำนวนผู้โดยสาร</label>
                    </div>
                </td>
                <td>
                    <div class="col-sm-6">
                        <input type="number" class="form-control" name="seat" id="seat" readonly>
                    </div>
                    <div class="col-sm-2">
                         <label>คน</label>
                    </div>
                </td>
                <td></td>
                 <td>
                    <div class="col-sm-16">
                        <label>&nbsp;&nbsp;&nbsp;จำนวนที่นั่ง</label>
                    </div>
                </td>
                <td>
                    <div class="col-xs-9">
                        <input type="number" class="form-control" name="seatcar" id="seatcar" readonly/>
                    </div>
                </td>
            </tr>
            <tr>
            	<td colspan="6">
                	<div class="col-sm-12"><br></div>
            	</td>
            </tr>
           
            <tr>
            	<td>
                    <div class="col-sm-16">
                    	<label>ข้อมูลเพิ่มเติม</label>
                	</div>
                </td>
                <td colspan="5">
                    <div class="col-sm-16">
                    	<textarea class="form-control" name="txtremark" id="txtremark" rows="7"></textarea>
                	</div>
                </td>
            </tr>
            <tr>
            	<td colspan="6">
                	<div class="col-sm-12"><br></div>
            	</td>
            </tr>
            <tr>
                <td align="right" colspan="6">
                    <div class="col-sm-12">
                    	<button  type="submit" class="btn btn-primary" id="save">Save</button>
               		</div>
                </td>
            </tr>
            <tr>
                <td colspan="6">
                    <div class="col-sm-12"><label>ไฟล์แนบ</label></div>
                    <p id="linkfile"></p>
                   <!-- <input type="text" id="linkfile2" size="50"> -->
                </td>
            </tr>
        </table>
        </form>
        </div>
</div>

<div id="dialogshowmail_hr"> 
             <div>ผู้จัดการ HR</div>
             <div>
             <table>
                 <tr>
                     <td class="col-sm-10">
                        <h5>
                        กรุณาเลือก Email ผู้จัดการ
                        </h5>
                     </td>
                 </tr>
                 <tr>
                     <td>
                        <input type="hidden" id="id_approve">
                        <input type="hidden" id="id_request">
                        <div id="checkEmailSend" class="col-sm-12"></div>
                     </td>
                 </tr>
             </table>
             <div class="modal-footer">
               
                <input  type="button" id='send4approve' value="Send" class="btn">
                <input  type="button" id='cancel' value="Cancel" class="btn">
                
             </div>
             </div>
</div>

<div id="dialogedit_hr">
        <div><strong>Manage </strong><span id="title_car"></span></div>
        <div>
        <form id="managefromhr" class="form-horizontal">
            <table>
                 <tr>
                    <td align="right">
                        <button  type="button" class="btn btn-danger" style="width:100px; height:50px;" id="removerecord"><h5><b>ยกเลิก</b></h5></button>
                        <button  type="button" class="btn btn-success" style="width:100px; height:50px;" id="addrecord"><h5><b>เพิ่มรายการ</b></h5></button>
                        <button  type="submit" class="btn btn-primary" style="width:100px; height:50px;" id="save"><h5><b>บันทึก</b></h5></button>
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <input type="checkbox" name="send_click" id="send_click"> <label>กรณีไม่ส่งผ่านผู้จัดการ</label>
                    
                    </td>
                </tr>
                <tr>
                    <td colspan="6">
                        <div class="col-sm-12"><br></div>
                    </td>
                </tr>
            </table>

            <table id="tbhide">  
            <tr>
                <td>
                    <div class="col-sm-16">
                        <label>เลือกรถ</label>
                        <input type="hidden" name="eid_approve" id="eid_approve">
                        <input type="hidden" name="eid_request" id="eid_request">
                    </div>
                </td>
                <td>
                    <div class="col-sm-12">
                        <input type="hidden" name="ecarid" id="ecarid">
                        <input type="textbox" class="form-control"  name="ecarname" id="ecarname" readonly>
                    </div>
                </td>
                <td>
                    <button class="btn btn-primary" type="button" id="eselectcar">click</button> 
                </td>
                 <td>
                    <div class="col-sm-16">
                        <label>&nbsp;&nbsp;&nbsp;เลือกพนักงานขับ</label>
                    </div>
                </td>
                <td>
                    <div class="col-sm-12">
                        <input type="hidden" name="edriverid" id="edriverid">
                        <input type="textbox" class="form-control"  name="edrivername" id="edrivername" readonly>
                    </div>
                </td>
                <td>
                    <button class="btn btn-primary" type="button" id="eselectdriver">click</button> 
                </td>
            </tr>
            <tr>
                <td colspan="6">
                    <div class="col-sm-12"><br></div>
                </td>
            </tr>
            <tr>
                <td>
                    <div class="col-sm-16">
                        <label>วันที่ใช้รถ</label>
                    </div>
                </td>
                <td colspan="2">
                    <div class="col-xs-9">
                        <div id='edatestart'>
                    </div>
                </td>
                <td>
                    <div class="col-sm-16">
                        <label>&nbsp;&nbsp;&nbsp;เวลารถออก</label>
                    </div>
                </td>
                <td>
                    <div class="col-xs-9">
                        <input type="text" class="form-control" name="estartTime" id="estartTime" readonly/>
                    </div>
                </td>
            </tr>
            <tr>
                <td colspan="6">
                    <div class="col-sm-12"><br></div>
                </td>
            </tr>
            <tr>
                <td>
                    <div class="col-sm-16">
                        <label>ใช้รถถึงวันที่</label>
                    </div>
                </td>
                <td colspan="2">
                    <div class="col-xs-9">
                        <div id='edateend'>
                    </div>
                </td>
                <td>
                    <div class="col-sm-16">
                        <label>&nbsp;&nbsp;&nbsp;เวลารถกลับ</label>
                    </div>
                </td>
                <td>
                    <div class="col-xs-9">
                        <input type="text" class="form-control" name="eendTime" id="eendTime" readonly/>
                    </div>
                </td>
                </tr>
                <tr>
                    <td colspan="6">
                        <div class="col-sm-12"><br></div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <div class="col-sm-16">
                            <label>จำนวนผู้โดยสาร</label>
                        </div>
                    </td>
                    <td>
                        <div class="col-sm-6">
                            <input type="hidden" class="form-control" name="eeeseat" id="eeeseat">
                            <input type="hidden" class="form-control" name="eeseat" id="eeseat">
                            <input type="number" class="form-control" name="eseat" id="eseat" readonly>
                        </div>
                        <div class="col-sm-2">
                             <label>คน</label>
                        </div>
                    </td>
                    <td></td>
                    <td>
                        <div class="col-sm-16">
                            <label>&nbsp;&nbsp;&nbsp;จำนวนที่นั่ง</label>
                        </div>
                    </td>
                    <td>
                        <div class="col-xs-9">
                            <input type="text" class="form-control" name="eseatcar" id="eseatcar" readonly/>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td colspan="6">
                        <div class="col-sm-12"><br></div>
                    </td>
                </tr>
               
                <tr>
                    <td>
                        <div class="col-sm-16">
                            <label>ข้อมูลเพิ่มเติม</label>
                        </div>
                    </td>
                    <td colspan="5">
                        <div class="col-sm-16">
                            <textarea class="form-control" name="etxtremark" id="etxtremark" rows="2"></textarea>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td colspan="6">
                        <div class="col-sm-12"><br></div>
                    </td>
                </tr>
            </table>
            <table width="100%">
                <tr>
                    <td>
                        <div id="grid2"></div>
                        <div id="grid3"></div>
                    </td>
                </tr>
               <!--  <tr>
                    <td align="right">
                        <button  type="button" class="btn btn-danger" id="removerecord">ยกเลิก</button>
                        <button  type="button" class="btn btn-success" id="addrecord">เพิ่มรายการ</button>
                        <button  type="submit" class="btn btn-primary" id="save">Save</button>
                    </td>
                </tr> -->

            </table>
        </form>
        </div>
</div>
<div id="dialogremark">
        <div><strong>Remark</strong></div>
        <div>
        <form id="remark" class="form-horizontal">
                <div class="col-sm-12">
                    <label>โปรดกรอกเหตุผล</label>
                    <textarea class="form-control" name="textremark" id="textremark" rows="4" cols="70"></textarea>
                </div>
                <div class="col-sm-12">
                  <hr>
                </div>
                <div class="col-sm-12" align="right">
                    <button  type="submit" class="btn btn-primary" id="saveremark">Save</button>
                </div>
        </form>
        </div>
</div>
<div id="dialog_addrequest">
    <div><strong>เพิ่มรายการ</strong></div>
    <div>
    <form id="addrequest" class="form-horizontal">
        <table>
             <tr>
                <td align="right">
                    <button  type="submit" class="btn btn-success" style="width:100px; height:50px;" id="saverequest"><h5><b>บันทึก</b></h5></button>
                </td>
            </tr>
            <tr>
                <td colspan="6">
                    <div class="col-sm-12"><br></div>
                </td>
            </tr>
        </table>

        <table id="tbhide">  
        <tr>
            <td>
                <div class="col-sm-16">
                    <label>เลือกรถ</label>
                    <input type="hidden" name="R_eid_approve" id="R_eid_approve">
                    <input type="hidden" name="R_eid_request" id="R_eid_request">
                </div>
            </td>
            <td>
                <div class="col-sm-12">
                    <input type="hidden" name="R_ecarid" id="R_ecarid">
                    <input type="textbox" class="form-control"  name="R_ecarname" id="R_ecarname" readonly>
                </div>
            </td>
            <td>
                <button class="btn btn-primary" type="button" id="R_eselectcar">click</button> 
            </td>
             <td>
                <div class="col-sm-16">
                    <label>&nbsp;&nbsp;&nbsp;เลือกพนักงานขับ</label>
                </div>
            </td>
            <td>
                <div class="col-sm-12">
                    <input type="hidden" name="R_edriverid" id="R_edriverid">
                    <input type="textbox" class="form-control"  name="R_edrivername" id="R_edrivername" readonly>
                </div>
            </td>
            <td>
                <button class="btn btn-primary" type="button" id="R_eselectdriver">click</button> 
            </td>
        </tr>
        <tr>
            <td colspan="6">
                <div class="col-sm-12"><br></div>
            </td>
        </tr>
        <tr>
            <td>
                <div class="col-sm-16">
                    <label>วันที่ใช้รถ</label>
                </div>
            </td>
            <td colspan="2">
                <div class="col-xs-9">
                    <div id='R_edatestart'>
                </div>
            </td>
            <td>
                <div class="col-sm-16">
                    <label>&nbsp;&nbsp;&nbsp;เวลารถออก</label>
                </div>
            </td>
            <td>
                <div class="col-xs-9">
                    <input type="text" class="form-control" name="R_estartTime" id="R_estartTime"/>
                </div>
            </td>
        </tr>
        <tr>
            <td colspan="6">
                <div class="col-sm-12"><br></div>
            </td>
        </tr>
        <tr>
            <td>
                <div class="col-sm-16">
                    <label>ใช้รถถึงวันที่</label>
                </div>
            </td>
            <td colspan="2">
                <div class="col-xs-9">
                    <div id='R_edateend'>
                </div>
            </td>
            <td>
                <div class="col-sm-16">
                    <label>&nbsp;&nbsp;&nbsp;เวลารถกลับ</label>
                </div>
            </td>
            <td>
                <div class="col-xs-9">
                    <input type="text" class="form-control" name="R_eendTime" id="R_eendTime"/>
                </div>
            </td>
            </tr>
            <tr>
                <td colspan="6">
                    <div class="col-sm-12"><br></div>
                </td>
            </tr>
            <tr>
                <td>
                    <div class="col-sm-16">
                        <label>จำนวนผู้โดยสาร</label>
                    </div>
                </td>
                <td>
                    <div class="col-sm-6">
                        <input type="hidden" class="form-control" name="R_eeeseat" id="R_eeeseat">
                        <input type="hidden" class="form-control" name="R_eeseat" id="R_eeseat">
                        <input type="number" class="form-control" name="R_eseat" id="R_eseat" readonly>
                        <input type="hidden" name="R_eseatSum" id="R_eseatSum">
                    </div>
                    <div class="col-sm-2">
                         <label>คน</label>
                    </div>
                </td>
                <td></td>
                <td>
                    <div class="col-sm-16">
                        <label>&nbsp;&nbsp;&nbsp;จำนวนที่นั่ง</label>
                    </div>
                </td>
                <td>
                    <div class="col-xs-9">
                        <input type="text" class="form-control" name="R_eseatcar" id="R_eseatcar" readonly/>
                    </div>
                </td>
            </tr>
            <tr>
                <td colspan="6">
                    <div class="col-sm-12"><br></div>
                </td>
            </tr>
           
            <tr>
                <td>
                    <div class="col-sm-16">
                        <label>ข้อมูลเพิ่มเติม</label>
                    </div>
                </td>
                <td colspan="5">
                    <div class="col-sm-16">
                        <textarea class="form-control" name="R_etxtremark" id="R_etxtremark" rows="2"></textarea>
                    </div>
                </td>
            </tr>
            <tr>
                <td colspan="6">
                    <div class="col-sm-12"><br></div>
                </td>
            </tr>
        </table>
        <table width="100%">
            <tr>
                <td>
                    <div id="grid_request"></div>
                </td>
            </tr>
        </table>
    </form>
    </div>
</div>
<script type="text/javascript">
	var theme_s = 'ui-redmond';
    var theme_b = 'ui-lightness';
	var record =[];
	var lastrecord; 
    var recordsum =[];
    var lastrecordsum;
    var record_sday =[];
    var lastrecord_sday;
    var record_eday =[];
    var lastrecord_eday;

    var recordfile =[];
    var lastrecordfile;
    //grid
	var customer_source =
    {
        datatype: "json",
        url : './cartransmanage',
        datafields: [
            { name: 'CarRequestID', type: 'int' },
            { name: 'NumberRequestID', type: 'string' },
            { name: 'FromDate', type: 'date' },
            { name: 'ToDate', type: 'date' },
            { name: 'FromTime', type: 'time'},
            { name: 'ToTime', type: 'time'},
            { name: 'Seat', type: 'int'},
            { name: 'Start', type: 'string'},
            { name: 'StartingPoint', type: 'string'},
            { name: 'Finished', type: 'string'},
            { name: 'Title', type: 'string'},
            { name: 'StatusID', type: 'int'},
            { name: 'CreateBy', type: 'int'},
            { name: 'NameMg', type: 'string'},
            { name: 'Name', type: 'string'},
            { name: 'StatusName', type: 'string'},
            { name: 'InternalCode', type: 'string'},
            { name: 'ApproveDate', type: 'string'}

        ]
    };

    var customer_adapter = new $.jqx.dataAdapter(customer_source);

    $("#grid").jqxGrid(
    {
        width: '100%',
        source: customer_adapter,  
        columnsresize: true,
        pageable: true,
        autoHeight: true,
        filterable: true,
        showfilterrow: true,
        enableanimations: false,
        altrows: true,
        sortable: true,
        pagesize: 10,
        selectionmode: 'checkbox',
        theme : theme_s,
        columns: [
            {text: 'รายการ',datafield: 'CarRequestID',width: 60},
            {text: 'วันที่ใช้รถ',datafield: 'FromDate',filtertype: 'range',cellsformat: 'dd-MM-yyyy',width: 80},
            {text: 'เวลารถออก',datafield: 'FromTime',width: 80},
            {text: 'ใช้รถถึงวันที่',datafield: 'ToDate',filtertype: 'range',cellsformat: 'dd-MM-yyyy',width: 80},
            {text: 'เวลารถกลับ',datafield: 'ToTime',width: 80},
            {text: 'จุดประสงค์การใช้รถ',datafield: 'Title',width: 200},
            {text: 'ผู้โดยสาร',datafield: 'Seat',width: 70},
            {text: 'ต้นทาง',datafield: 'InternalCode',width:120, 
                cellsrenderer: function (index, datafield, value, defaultvalue, column, rowdata){
                var status;
                status =  "<div style='padding: 5px; background:#00BB00 ; color:#ffffff;'>"+value+"</div>";
                return status;
                }
            },

            {text: 'ปลายทาง',datafield: 'Finished',width: 120,
        		cellsrenderer: function (index, datafield, value, defaultvalue, column, rowdata){
                var status;
                status =  "<div style='padding: 5px; background:#EE0000 ; color:#ffffff;'>"+value+"</div>";
                return status;
                }
            },
            {text: 'จุดขึ้นรถ',datafield: 'StartingPoint',width: 120},
            {text: 'Status',datafield: 'StatusName',filtertype: 'checkedlist',width: 80},
            {text: 'สร้างโดย',datafield: 'Name',width: 120},
            {text: 'อนุมัติโดย',datafield: 'NameMg',width: 120},
            {text: 'วันที่อนุมัติ',datafield: 'ApproveDate',filtertype: 'range',cellsformat: 'dd-MM-yyyy',width: 80},
        ]
    });   

    //gridtrans
    var customer_source =
    {
        datatype: "json",
        url : './cartransmanaged',
        datafields: [
            { name: 'CarApproveID', type: 'int' },
            { name: 'CarRequestID', type: 'string' },
            { name: 'CarID', type: 'int' },
            { name: 'DriverID', type: 'int'},
            { name: 'Remark', type: 'string'},
            { name: 'StartDate', type: 'date'},
            { name: 'EndDate', type: 'date'},
            { name: 'StartTime', type: 'time'},
            { name: 'EndTime', type: 'time'},
            { name: 'CreateBy', type: 'string'},
            { name: 'CreateDate', type: 'int'},
            { name: 'CarRegistration', type: 'string'},
            { name: 'Seat', type: 'int'},
            { name: 'CarTypeID', type: 'int'},
            { name: 'CarTypeName', type: 'string'},
            { name: 'DriverName', type: 'string'},
            { name: 'StatusID', type: 'int'},
            { name: 'StatusName', type: 'string'}

        ]
    };

    var customer_adapter = new $.jqx.dataAdapter(customer_source);

    $("#gridtrans").jqxGrid(
    {
        width: '100%',
        source: customer_adapter,  
        columnsresize: true,
        pageable: true,
        autoHeight: true,
        filterable: true,
        showfilterrow: true,
        enableanimations: false,
        altrows: true,
        sortable: true,
        pagesize: 10,
        //selectionmode: 'checkbox',
        theme : theme_s,
        columns: [
            //{text: 'ID',datafield: 'CarApproveID',width:50},
            {text: 'รายการ',datafield: 'CarRequestID'},
            {text: 'ทะเบียนรถ',datafield: 'CarRegistration',width:100},
            {text: 'พนักงานขับรถ',datafield: 'DriverName',width:150},
            {text: 'ผู้โดยสาร',datafield: 'Seat',width:70},
            {text: 'หมายเหตุ',datafield: 'Remark',width:350},
            {text: 'วันที่ใช้รถ',datafield: 'StartDate',filtertype: 'range',cellsformat: 'dd-MM-yyyy',width: 80},
            {text: 'ใช้รถถึงวันที่',datafield: 'EndDate',filtertype: 'range',cellsformat: 'dd-MM-yyyy',width: 80},
            {text: 'เวลารถออก',datafield: 'StartTime',width: 80},
            {text: 'เวลารถกลับ',datafield: 'EndTime',width: 80},
            {text: 'Status',datafield: 'StatusName',width: 80,filtertype: 'checkedlist'}
            
        ]
    });   

    $('#gridtrans').on('rowdoubleclick', function (event) 
      {
        var args = event.args;
        var boundIndex = args.rowindex;        
        var datarow = $("#gridtrans").jqxGrid('getrowdata', boundIndex);
        //alert(datarow.CarApproveID);
    });
    $('#grid').on('rowdoubleclick', function (event) 
      {
        var args = event.args;
        var boundIndex = args.rowindex;        
        var datarow = $("#grid").jqxGrid('getrowdata', boundIndex);
        //alert(datarow.CarRequestID);  
        $('#dialogdetail').jqxWindow('open');
        //$('#carrequestid').val(datarow.CarRequestID);
        document.getElementById("demo").innerHTML = "รายการที่"+datarow.CarRequestID;
        document.getElementById("start").innerHTML = datarow.InternalCode;
        document.getElementById("finish").innerHTML = datarow.Finished;
        if (datarow.StartingPoint!="") {
            document.getElementById("point").innerHTML = datarow.StartingPoint;
        }else{
            document.getElementById("point").innerHTML = "-";    
        }
       
    
            function formatDate(date) {
                var d = new Date(date),
                    month = '' + (d.getMonth() + 1),
                    day = '' + d.getDate(),
                    year = d.getFullYear();

                if (month.length < 2) month = '0' + month;
                if (day.length < 2) day = '0' + day;

                return [day, month, year].join('/');
            }
            //alert(formatDate('Sun May 11,2014'));
        document.getElementById("date_st").innerHTML = formatDate(datarow.ToDate);
        document.getElementById("date_en").innerHTML = formatDate(datarow.FromDate);
        document.getElementById("time_st").innerHTML = datarow.FromTime;
        document.getElementById("time_en").innerHTML = datarow.ToTime;
        document.getElementById("seatt").innerHTML = datarow.Seat+" คน";
        document.getElementById("titlee").innerHTML = datarow.Title;
        document.getElementById("createbyy").innerHTML = datarow.Name;
        document.getElementById("mgbyy").innerHTML = datarow.NameMg;

        /*$.getJSON('./linkfilemy?no='+datarow.NumberRequestID+'&ran='+Math.random()*99999)
            .done(function(data){
              var i=1;
              $.each(data, function( k, v ) {
                var filename = v.FileName;
                
                      $('#linkmy').append("<a target='_blank' href='upload/" + v.FileName + "'>" + v.FileName + "</a><br>");
                      i++;
                }); 
        });*/
    });


    var car_source =
    {
        datatype: "json",
        url : './carmaster_manage',
        datafields: [
            { name: 'CarID', type: 'int' },
            { name: 'CarRegistration', type: 'string' },
            { name: 'Seat', type: 'int' },
            { name: 'CarTypeID', type: 'int' },
            { name: 'CarTypeName', type: 'string'},
            { name: 'CompanyID', type: 'string' },
            { name: 'CarStatus', type: 'int' }

        ]
    };

    var car_adapter = new $.jqx.dataAdapter(car_source);

    $("#carform").jqxGrid(
    {
        width: '98%',
        source: car_adapter,  
        pageable: true,
        autoHeight: true,
        filterable: true,
        showfilterrow: true,
        enableanimations: false,
        altrows: true,
        sortable: true,
        pagesize: 5,
        theme : theme_s,
        columns: [
            //{text: 'CarID',datafield: 'CarID'},
            {text: 'เลขทะเบียน',datafield: 'CarRegistration'},
            {text: 'ชนิดรถ',datafield: 'CarTypeName'}
        ]
    });   
    $('#carform').on('rowdoubleclick', function (event) 
      {
        var args = event.args;
        var boundIndex = args.rowindex;        
        var datarow = $("#carform").jqxGrid('getrowdata', boundIndex);
        $('#carid').val(datarow.CarID);
        $('#carname').val(datarow.CarRegistration);
        $('#seatcar').val(datarow.Seat);
        alert($('#carname').val());

        $('#dialogcar').jqxWindow('close');
    });

    var driver_source =
    {
        datatype: "json",
        url : './drivermaster',
        datafields: [
            { name: 'DriverID', type: 'int' },
            { name: 'DriverName', type: 'string' },
            { name: 'Tel', type: 'string' },
            { name: 'CompanyID', type: 'string'}

        ]
    };

    var driver_adapter = new $.jqx.dataAdapter(driver_source);

    $("#driverform").jqxGrid(
    {
        width: '98%',
        source: driver_adapter,  
        pageable: true,
        autoHeight: true,
        filterable: true,
        showfilterrow: true,
        enableanimations: false,
        altrows: true,
        sortable: true,
        pagesize: 5,
        theme : theme_s,
        columns: [
           {text: 'ชื่อพนังงานขับรถ',datafield: 'DriverName'}
        ]
    });   
    $('#driverform').on('rowdoubleclick', function (event) 
      {
        var args = event.args;
        var boundIndex = args.rowindex;        
        var datarow = $("#driverform").jqxGrid('getrowdata', boundIndex);
        $('#driverid').val(datarow.DriverID);
        $('#drivername').val(datarow.DriverName);
        
        alert($('#drivername').val());

        $('#dialogdriver').jqxWindow('close');
    });


    $("#datestart").jqxDateTimeInput({ width: '190px', height: '40px' ,theme: theme_s});
    $("#dateend").jqxDateTimeInput({ width: '190px', height: '40px' ,theme: theme_s});
    $("#edatestart").jqxDateTimeInput({ width: '190px', height: '40px' ,theme: theme_s ,disabled:true});
    $("#edateend").jqxDateTimeInput({ width: '190px', height: '40px' ,theme: theme_s ,disabled:true});
    $("#R_edatestart").jqxDateTimeInput({ width: '190px', height: '40px' ,theme: theme_s ,disabled:true});
    $("#R_edateend").jqxDateTimeInput({ width: '190px', height: '40px' ,theme: theme_s ,disabled:true});

    $('#dialogmanage').jqxWindow({
             maxWidth: 1000,
             width : 900,
             height : 520,
             autoOpen : false,
             isModal : true,
             theme : theme_s      
    });

    $('#dialogcar').jqxWindow({
             //maxWidth: 1000,
             width : 310,
             height : 265,
             autoOpen : false,
             isModal : true,
             theme : theme_s      
    });
    $('#dialogdriver').jqxWindow({
             //maxWidth: 1000,
             width : 310,
             height : 265,
             autoOpen : false,
             isModal : true,
             theme : theme_s      
    });
    $('#dialogecar').jqxWindow({
             //maxWidth: 1000,
             width : 310,
             height : 265,
             autoOpen : false,
             isModal : true,
             theme : theme_s      
    });
    $('#dialogedriver').jqxWindow({
             //maxWidth: 1000,
             width : 310,
             height : 265,
             autoOpen : false,
             isModal : true,
             theme : theme_s      
    });
    $('#dialogshowmail_hr').jqxWindow({
             width : 400,
             height : 400,
             autoOpen : false,
             isModal : true,
             theme : theme_s     
    });
    $('#dialogedit_hr').jqxWindow({
             maxWidth: 1000,
             width : 900,
             height : 700,
             autoOpen : false,
             isModal : true,
             theme : theme_s      
    });
    $('#dialogdetail').jqxWindow({
             //maxWidth: 1000,
             width : 700,
             height : 520,
             autoOpen : false,
             isModal : true,
             theme : theme_s      
    });

    $("#selectcar").on('click',function(){
        $('#dialogcar').jqxWindow('open');
    });
    $("#selectdriver").on('click',function(){
        $('#dialogdriver').jqxWindow('open');
    });
    $("#eselectcar").on('click',function(){
        $('#dialogecar').jqxWindow('open');
    });
    $("#eselectdriver").on('click',function(){
        $('#dialogedriver').jqxWindow('open');
    });

    $("#manage").bind('click', function () {
        if(record.length == 0){
            gotify("กรุณาเลือกรายการ !","danger");
           //swal("กรุณาเลือกรายการ !");
        }else{
        	//alert(record);
            var selectedrowindex = $("#grid").jqxGrid('getselectedrowindex');
            var datarow = $("#grid").jqxGrid('getrowdata', selectedrowindex);
            
        	$('#dialogmanage').jqxWindow('open');
                
                var a = record_sday;
                a.sort(function(a, b){
                    return Date.parse(a) - Date.parse(b);
                });
                var minT = a[0];

                var a = record_eday;
                a.sort(function(a, b){
                    return Date.parse(a) - Date.parse(b);
                });
                var maxE = a[a.length-1];
                

                $('#datestart').val(minT);
                $('#dateend').val(maxE);

                time = datarow.FromTime;
                timeArray = time.split(":",-1);
                $('#startTime').val(timeArray[0]+":"+timeArray[1]);
                time = datarow.ToTime;
                timeArray = time.split(":",-1);
                $('#endTime').val(timeArray[0]+":"+timeArray[1]);
                
                //$('#datestart').val(datarow.FromDate);
                //$('#dateend').val(datarow.ToDate);
                
               //$('#seat').val();
               var sum = recordsum.reduce(add, 0);

                function add(a, b) {
                    return a + b;
                }
                
                $('#seat').val(sum);

                //$('#linkfile2').val(record);
                    $.getJSON('./linkfile?no='+recordfile+'&ran='+Math.random()*99999)
                    .done(function(data){
                      var i=1;
                      $.each(data, function( k, v ) {
                        var filename = v.FileName;
                        
                              $('#linkfile').append("<a target='_blank' href='upload/" + v.FileName + "'>" + v.FileName + "</a><br>");
                              i++;
                          }); 
                    });
               
        }
    });

    $('#dialogmanage').on('close', function (event) {
        location.reload();
    });

    var TIME_PATTERN = /^((2[0-3])|([01][0-9])):[0-5][0-9]$/;

    $('#managefrom').on('submit', function(e) {
        e.preventDefault();
        var x = $('#seat').val();
        var y = $('#seatcar').val();

        var st_date = $('#datestart').val();
        var carid = $('#carid').val();
        /*var url = "./checkedcarregis?carid="+carid+"&st_date="+st_date;
            $.get(url, function(data){
                console.log(data);
                $('#checkedcarregis').val(data);
            });*/

      	if($.trim($('#carname').val())==''){
            gotify("กรุณาเลือกรถ","danger")
        }else if($.trim($('#drivername').val())==''){
             gotify("กรุณาเลือกพนักงานขับรถ","danger")
        }else if($('#datestart').val() > $('#dateend').val()){
             gotify("วันที่ใช้รถต้องน้อยกว่าวันที่รถถึง","danger")
        }else if($.trim($('#startTime').val())==''){
             gotify("กรุณากรอกเวลา","danger")
        }else if (TIME_PATTERN.test($('#startTime').val())===false){
            gotify("กรุณาช็ครูปแบบเวลา (ตัวอย่าง 08:00)","danger")
        }else if($.trim($('#endTime').val())==''){
             gotify("กรุณากรอกเวลา","danger")
        }else if (TIME_PATTERN.test($('#endTime').val())===false){
            gotify("กรุณาช็ครูปแบบเวลา (ตัวอย่าง 08:00)","danger")
        }else if($.trim($('#seat').val())==''){
             gotify("กรุณาใส่จำนวนผู้โดยสาร","danger")
        }else if(parseFloat(x) > parseFloat(y)){
             gotify("จำนวนที่นั่งไม่พอสำหรับจำนวนผู้โดยสาร","danger")
        }else if($.trim($('#txtremark').val())==''){
             gotify("กรุณากรอกข้อมูลเพิ่มเติม","danger")
       /* }else if($.trim($('#checkedcarregis').val())==1){
             gotify("รถคันนี้ถูกใช้งานไปแล้ว","danger")*/
      	}else{
            
          	$.ajax({
            url : './carapprovetans',
            type : 'post',
            data : {
              record : record,
              carid : $('#carid').val(),
              carname : $('#carname').val(),
              driverid : $('#driverid').val(),
              drivername : $('#drivername').val(),
              datestart : $('#datestart').val(),
              dateend : $('#dateend').val(),
              startTime : $('#startTime').val(),
              endTime : $('#endTime').val(),
              txtremark : $('#txtremark').val(),
              seat : $('#seat').val()
            },
            success : function(data){
                //alert(data);
                if (data==1){
                    gotify("ดำเนินการสำเร็จ","success")
                    $('#dialogmanage').jqxWindow('close');
                    location.reload();
                }else if(data==11){
                    gotify("รถคันนี้ถูกใช้งานไปแล้ว","danger");
                }else{
                    gotify("เกิดข้อผิดพลาด","danger");
                }
                
              
            }
          });          	
	      
    	}

    });

    $('#send').on('click',function (){
        var selectedrowindex = $("#gridtrans").jqxGrid('getselectedrowindex');
        var datarow = $("#gridtrans").jqxGrid('getrowdata', selectedrowindex);
        if (datarow.StatusID!=5) {
            if (datarow) {
                $('#dialogshowmail_hr').jqxWindow('show');
                $('#id_approve').val(datarow.CarApproveID);
                $('#id_request').val(datarow.CarRequestID);
                $.getJSON( "./listmailmanager_hr",function( data ) {
                    $('#checkEmailSend').html("");
                      $.each( data, function( key, val ){
                          $('#checkEmailSend').append( "<label><input type='checkbox' class='ccEmail' name='cEmail[]' value='"+val.Email+"'> "+val.Email+"&nbsp;&nbsp;&nbsp;("+val.Name+")</label><br>" );
                      });
                });

            }else{
                //alert('please select rows');
                gotify("กรุณาเลือกรายการ","danger")
            }
        }else{
            gotify("ไม่สามารถส่งได้","danger")
        }
    });

    $('#send4approve').click(function(e){
            e.preventDefault();
            $('#send4approve').prop('disabled',true);
            $('#cancel').prop('disabled',true);
            $('#send4approve').val('รอสักครู่...'); 
           
            var vals = [];
            var vals_not = [];
              $(':checkbox:checked').each(function(i,v){
                vals[i] = $(this).val();
              });
              $(':checkbox').each(function(i,v){
                vals_not[i] = $(this).val();
              });
            
            $.ajax({
              url : './sendemail_hr',
              type : 'post',
              data : {
                mail : vals,
                mail_not : vals_not,
                id_approve : $('#id_approve').val(),
                id_request : $('#id_request').val()

              },
              success : function(data) {
                 // alert(data);
                 gotify(data,"success")
                 $('#gridtrans').jqxGrid('updatebounddata');
                 $('#dialogshowmail_hr').jqxWindow('close');
                 $('#send4approve').prop('disabled',false);
                 $('#send4approve').val('Send'); 
              }
            });
    });

    $('#gridtrans').on('rowclick', function(event) {
            $('#canceled').prop('disabled', false);
            $('#edit').prop('disabled', false);
            $('#send').prop('disabled', false);
    });
    $('#dialogremark').jqxWindow({
             width : 500,
             height : 280,
             autoOpen : false,
             isModal : true,
             theme : theme_s     
    });
    $('#cancel').on('click',function (){
        var selectedrowindex = $("#grid").jqxGrid('getselectedrowindex');
        var datarow = $("#grid").jqxGrid('getrowdata', selectedrowindex);
        if (datarow) {
            if (confirm('Are you sure?')) {
               //alert(record);
               $('#dialogremark').jqxWindow('open');   
            }
        }else{
            gotify("กรุณาเลือกรายการ","danger");
        }    
    });

    $('#remark').submit(function(e){
        e.preventDefault();

        if($.trim($('#textremark').val())==''){
            gotify("กรุณากรอกเหตุผล","danger")
        }else{

            $.ajax({
                url : './cancel',
                type : 'post',
                data : {
                  id_req : record,
                  remark : $('#textremark').val()
                },
                success : function(data){
                    //alert(data);
                    // console.log(data);
                    if (data==1) {
                        gotify("ดำเนินการสำเร็จ","success")
                        location.reload();
                    }else if(data=='Error'){
                        gotify("เกิดข้อผิดพลาด","danger")
                    }else{
                        gotify("ดำเนินการสำเร็จ \n ส่งเมลล์ไม่ผ่าน","warning")
                    }
                    
                }
            });
        }
    });

    $('#canceled').on('click',function (){
        var selectedrowindex = $("#gridtrans").jqxGrid('getselectedrowindex');
        var datarow = $("#gridtrans").jqxGrid('getrowdata', selectedrowindex);
        //$('#id_car').val(datarow.CarApproveID);
        //$('#id_req').val(datarow.CarRequestID);
        
        if (!!datarow) {
            if (confirm('Are you sure?')) {
              //alert(datarow.CarApproveID);
                
                $.ajax({
                    url : './canceled_all',
                    type : 'post',
                    data : {
                      id_car : datarow.CarApproveID,
                      id_req : datarow.CarRequestID,
                      status : datarow.StatusID
                    },
                    success : function(data){
                        //alert(data);
                        if (data==1) {
                            gotify("ดำเนินการสำเร็จ","success")
                        }else{
                            gotify("เกิดข้อผิดพลาด","danger")
                        }
                        location.reload();
                        //$('#dialogadd').jqxWindow('close');
                        //$('#grid').jqxGrid('updatebounddata');  
                        //$('#grid2').jqxGrid('updatebounddata');  
                        //$('#gridtrans').jqxGrid('updatebounddata');    
                    }
                });

            }
        }
        

            
    });

    //grid2
    var record2 =[];
    var lastrecord2; 
    var recordsum2 =[];
    var lastrecordsum2;

    var customer_source =
    {
        datatype: "json",
        url : './cartransmanage',
        datafields: [
            { name: 'CarRequestID', type: 'int' },
            { name: 'NumberRequestID', type: 'string' },
            { name: 'FromDate', type: 'date' },
            { name: 'ToDate', type: 'date' },
            { name: 'FromTime', type: 'time'},
            { name: 'ToTime', type: 'time'},
            { name: 'Seat', type: 'int'},
            { name: 'Start', type: 'string'},
            { name: 'StartingPoint', type: 'string'},
            { name: 'Finished', type: 'string'},
            { name: 'Title', type: 'string'},
            { name: 'StatusID', type: 'int'},
            { name: 'CreateBy', type: 'int'},
            { name: 'NameMg', type: 'string'},
            { name: 'Name', type: 'string'},
            { name: 'StatusName', type: 'string'}

        ]
    };

    var customer_adapter = new $.jqx.dataAdapter(customer_source);

    $("#grid2").jqxGrid(
    {
        width: '100%',
        source: customer_adapter,  
        pageable: true,
        autoHeight: true,
        filterable: true,
        showfilterrow: true,
        enableanimations: false,
        altrows: true,
        sortable: true,
        pagesize: 10,
        pagesizeoptions: ['3', '10', '20'],
        selectionmode: 'checkbox',
        theme : theme_s,
        columns: [
            {text: 'รายการ',datafield: 'CarRequestID',width: 60},
            {text: 'วันที่ใช้รถ',datafield: 'FromDate',filtertype: 'range',cellsformat: 'dd-MM-yyyy',width: 80},
            {text: 'เวลารถออก',datafield: 'FromTime',width: 80},
            {text: 'ใช้รถถึงวันที่',datafield: 'ToDate',filtertype: 'range',cellsformat: 'dd-MM-yyyy',width: 80},
            {text: 'เวลารถกลับ',datafield: 'ToTime',width: 80},
            {text: 'จุดประสงค์การใช้รถ',datafield: 'Title',width: 200},
            {text: 'ผู้โดยสาร',datafield: 'Seat',width: 50},
            {text: 'ต้นทาง',datafield: 'Start',width:120, 
                cellsrenderer: function (index, datafield, value, defaultvalue, column, rowdata){
                var status;
                status =  "<div style='padding: 5px; background:#00BB00 ; color:#ffffff;'>"+value+"</div>";
                return status;
                }
            },

            {text: 'ปลายทาง',datafield: 'Finished',width: 120,
                cellsrenderer: function (index, datafield, value, defaultvalue, column, rowdata){
                var status;
                status =  "<div style='padding: 5px; background:#EE0000 ; color:#ffffff;'>"+value+"</div>";
                return status;
                }
            },
            {text: 'จุดขึ้นรถ',datafield: 'StartingPoint',width: 120},
            {text: 'Status',datafield: 'StatusName',filtertype: 'checkedlist',width: 80},
            {text: 'สร้างโดย',datafield: 'Name',width: 120},
            {text: 'อนุมัติโดย',datafield: 'NameMg',width: 120},
            
        ]
    });   

    //grid3
    var record3 =[];
    var lastrecord3; 
    var recordsum3 =[];
    var lastrecordsum3;

    function LoadGird3(car_reqid)
    {
        var customer_source =
        {
            datatype: "json",
            url : './cartransmanaget?car_reqid='+car_reqid,
            datafields: [
                { name: 'CarRequestID', type: 'int' },
                { name: 'NumberRequestID', type: 'string' },
                { name: 'FromDate', type: 'date' },
                { name: 'ToDate', type: 'date' },
                { name: 'FromTime', type: 'time'},
                { name: 'ToTime', type: 'time'},
                { name: 'Seat', type: 'int'},
                { name: 'Start', type: 'string'},
                { name: 'StartingPoint', type: 'string'},
                { name: 'Finished', type: 'string'},
                { name: 'Title', type: 'string'},
                { name: 'StatusID', type: 'int'},
                { name: 'CreateBy', type: 'int'},
                { name: 'NameMg', type: 'string'},
                { name: 'Name', type: 'string'},
                { name: 'StatusName', type: 'string'}

            ]
        };

        var customer_adapter = new $.jqx.dataAdapter(customer_source);

        return $("#grid3").jqxGrid(
        {
            width: '100%',
            source: customer_adapter,  
            pageable: true,
            autoHeight: true,
            filterable: true,
            showfilterrow: true,
            enableanimations: false,
            altrows: true,
            sortable: true,
            pagesize: 3,
            pagesizeoptions: ['3', '10', '20'],
            selectionmode: 'checkbox',
            theme : theme_s,
            columns: [
                {text: 'รายการ',datafield: 'CarRequestID',width: 60},
                {text: 'วันที่ใช้รถ',datafield: 'FromDate',filtertype: 'range',cellsformat: 'dd-MM-yyyy',width: 80},
                {text: 'เวลารถออก',datafield: 'FromTime',width: 80},
                {text: 'ใช้รถถึงวันที่',datafield: 'ToDate',filtertype: 'range',cellsformat: 'dd-MM-yyyy',width: 80},
                {text: 'เวลารถกลับ',datafield: 'ToTime',width: 80},
                {text: 'จุดประสงค์การใช้รถ',datafield: 'Title',width: 200},
                {text: 'ผู้โดยสาร',datafield: 'Seat',width: 50},
                {text: 'ต้นทาง',datafield: 'Start',width:120, 
                    cellsrenderer: function (index, datafield, value, defaultvalue, column, rowdata){
                    var status;
                    status =  "<div style='padding: 5px; background:#00BB00 ; color:#ffffff;'>"+value+"</div>";
                    return status;
                    }
                },

                {text: 'ปลายทาง',datafield: 'Finished',width: 120,
                    cellsrenderer: function (index, datafield, value, defaultvalue, column, rowdata){
                    var status;
                    status =  "<div style='padding: 5px; background:#EE0000 ; color:#ffffff;'>"+value+"</div>";
                    return status;
                    }
                },
                {text: 'จุดขึ้นรถ',datafield: 'StartingPoint',width: 120},
                {text: 'Status',datafield: 'StatusName',filtertype: 'checkedlist',width: 80},
                {text: 'สร้างโดย',datafield: 'Name',width: 120},
                {text: 'อนุมัติโดย',datafield: 'NameMg',width: 120},
                
            ]
        });   
    }

    var car_source =
    {
        datatype: "json",
        url : './carmaster_manage',
        datafields: [
            { name: 'CarID', type: 'int' },
            { name: 'CarRegistration', type: 'string' },
            { name: 'Seat', type: 'int' },
            { name: 'CarTypeID', type: 'int' },
            { name: 'CarTypeName', type: 'string'},
            { name: 'CompanyID', type: 'string' },
            { name: 'CarStatus', type: 'int' }

        ]
    };

    var car_adapter = new $.jqx.dataAdapter(car_source);

    $("#ecarform").jqxGrid(
    {
        width: '98%',
        source: car_adapter,  
        pageable: true,
        autoHeight: true,
        filterable: true,
        showfilterrow: true,
        enableanimations: false,
        altrows: true,
        sortable: true,
        pagesize: 5,
        theme : theme_s,
        columns: [
            //{text: 'CarID',datafield: 'CarID'},
            {text: 'เลขทะเบียน',datafield: 'CarRegistration'},
            {text: 'ชนิดรถ',datafield: 'CarTypeName'}
        ]
    });   
    $('#ecarform').on('rowdoubleclick', function (event) 
      {
        var args = event.args;
        var boundIndex = args.rowindex;        
        var datarow = $("#ecarform").jqxGrid('getrowdata', boundIndex);
        $('#ecarid').val(datarow.CarID);
        $('#ecarname').val(datarow.CarRegistration);
        $('#eseatcar').val(datarow.Seat);
        alert($('#ecarname').val());

        $('#R_ecarid').val(datarow.CarID);
        $('#R_ecarname').val(datarow.CarRegistration);
        $('#R_eseatcar').val(datarow.Seat);

        $('#dialogecar').jqxWindow('close');
    });

    var driver_source =
    {
        datatype: "json",
        url : './drivermaster',
        datafields: [
            { name: 'DriverID', type: 'int' },
            { name: 'DriverName', type: 'string' },
            { name: 'Tel', type: 'string' },
            { name: 'CompanyID', type: 'string'}

        ]
    };

    var driver_adapter = new $.jqx.dataAdapter(driver_source);

    $("#edriverform").jqxGrid(
    {
        width: '98%',
        source: driver_adapter,  
        pageable: true,
        autoHeight: true,
        filterable: true,
        showfilterrow: true,
        enableanimations: false,
        altrows: true,
        sortable: true,
        pagesize: 5,
        theme : theme_s,
        columns: [
           {text: 'ชื่อพนังงานขับรถ',datafield: 'DriverName'}
        ]
    });   
    $('#edriverform').on('rowdoubleclick', function (event) 
      {
        var args = event.args;
        var boundIndex = args.rowindex;        
        var datarow = $("#edriverform").jqxGrid('getrowdata', boundIndex);
        $('#edriverid').val(datarow.DriverID);
        $('#edrivername').val(datarow.DriverName);
        alert($('#edrivername').val());

        $('#R_edriverid').val(datarow.DriverID);
        $('#R_edrivername').val(datarow.DriverName);
        $('#dialogedriver').jqxWindow('close');
    });

    $('#dialogedit_hr').on('close', function (event) {
        //$('#gridtrans').jqxGrid('clearselection');
        location.reload();
    });

    $("#addrecord").on('click',function(){
        $('#addrecord').prop('disabled',true);
        $('#removerecord').prop('disabled',false);
        $('#grid3').hide();
        $('#grid2').show();
        $('#tbhide').hide();
        $('#title_car').text("Add");
        });
    $("#removerecord").on('click',function(){
        $('#removerecord').prop('disabled',true);
        $('#addrecord').prop('disabled',false);
        $('#grid3').show();
        $('#grid2').hide();
        $('#tbhide').show();
        $('#title_car').text("Cancel");
    });

    $('#edit').on('click',function (){
        var selectedrowindex = $("#gridtrans").jqxGrid('getselectedrowindex');
        var datarow = $("#gridtrans").jqxGrid('getrowdata', selectedrowindex);
        $('#grid2').hide();
        
        if (datarow.StatusID!=3 && datarow.StatusID!=9) {
            gotify("ไม่สามารถแก้ไขรายการได้","danger")
        }else{
        
            $('#dialogedit_hr').jqxWindow('open');
            
            LoadGird3(datarow.CarRequestID);           
            $('#title_car').text("Cancel");

            $('#removerecord').prop('disabled',true);
            var ecarid = datarow.CarID;
            var url = "./checkedcar?carid="+ecarid;
            $.get(url, function(data){
                //console.log(data);
                $('#eseatcar').val(data);
            });

            $('#eid_approve').val(datarow.CarApproveID);
            $('#eid_request').val(datarow.CarRequestID);
            $('#ecarid').val(datarow.CarID);
            $('#ecarname').val(datarow.CarRegistration);
            $('#edriverid').val(datarow.DriverID);
            $('#edrivername').val(datarow.DriverName);
            $('#eseat').val(datarow.Seat);
            $('#etxtremark').val(datarow.Remark);
            
                time = datarow.StartTime;
                timeArray = time.split(":",-1);
                $('#estartTime').val(timeArray[0]+":"+timeArray[1]);
                time = datarow.EndTime;
                timeArray = time.split(":",-1);
                $('#eendTime').val(timeArray[0]+":"+timeArray[1]);
               
                $('#edatestart').val(datarow.StartDate);
                $('#edateend').val(datarow.EndDate);

        }
    });

    $('#managefromhr').on('submit', function(e) {
        e.preventDefault();
            if ($('input[name=send_click]').is(':checked') == true){
                send_click =1;
            }else{
                send_click =0;
            }

            if ($('#addrecord').prop('disabled')==true) { 
                XD = 'ON';
            }else if($('#addrecord').prop('disabled')==false){
                XD = 'OFF';
            }
        
        a_id = $('#eid_approve').val();
        c_id = $('#eid_request').val();
        ecarid = $('#ecarid').val();
        edriverid = $('#edriverid').val();
        edatestart = $('#edatestart').val();
        edateend = $('#edateend').val();
        estartTime = $('#estartTime').val();
        eendTime = $('#eendTime').val();
        etxtremark = $('#etxtremark').val();
        e_seat = $('#eseat').val();
        sum_row = $('#eeseat').val();

        if (record2!="") {
            comma = ",";
        }else{
            comma = "";
        }

        requestid = (record2+comma+c_id);
        var TIME_PATTERN = /^((2[0-3])|([01][0-9])):[0-5][0-9]$/;
        var x = $('#eseatcar').val();
        var a1=parseFloat(e_seat);
        var a2=parseFloat($('#eeseat').val());
        y=a1+a2;

        if(edatestart > edateend){
            gotify("กรุณากรอก วันที่ให้ถูกต้อง","danger")
        }else if($.trim(estartTime)==''){
            gotify("กรุณากรอก เวลา","danger")
        }else if (TIME_PATTERN.test(estartTime)===false){
            gotify("กรุณาช็ครูปแบบเวลา (ตัวอย่าง 08:00)","danger")
        }else if($.trim(eendTime)==''){
            gotify("กรุณากรอก เวลา","danger")
        }else if (TIME_PATTERN.test(eendTime)===false){
            gotify("กรุณาช็ครูปแบบเวลา (ตัวอย่าง 08:00)","danger")
        }else if(parseFloat(x) < parseFloat(y)){
             gotify("จำนวนที่นั่งไม่พอสำหรับจำนวนผู้โดยสาร","danger")
        }else if(parseFloat($('#eseat').val()) > parseFloat(x)){
             gotify("จำนวนที่นั่งไม่พอสำหรับจำนวนผู้โดยสาร","danger")
        }else{
            
            $.ajax({
                url : './updatehradminmanage',
                type : 'post',
                data : {
                  ecarid : ecarid,
                  edriverid : edriverid,
                  edatestart : edatestart,
                  edateend : edateend,
                  estartTime : estartTime,
                  eendTime : eendTime,
                  etxtremark : etxtremark,
                  e_seat : e_seat,
                  sum_row : sum_row,
                  requestid : requestid,
                  a_id : a_id,
                  record2 : record2,
                  record3 : record3,
                  sum_row3 : $('#eeeseat').val(),
                  c_id : c_id,
                  XD : XD,
                  send_click : send_click
                },
                success : function(data){
                    //alert(data);
                    if (data==1) {
                        gotify("บันทึกสำเร็จ","success")
                        $('#dialogedit_hr').jqxWindow('close');
                    }else if(data==11){
                        gotify("รถคันนี้ถูกใช้งานไปแล้ว","danger")
                    }else{
                        gotify("เกิดข้อผิดพลาด","danger")
                    }
                    
                    //$('#dialogedit_hr').jqxWindow('close');

                }
            });
        }

    });

    //gridrow
    $("#grid").on('rowselect', function (event) {
        var args = event.args;
        var rowBoundIndex = args.rowindex;
        var rowData = args.row;
        record.push(rowData.CarRequestID);
        lastrecord = rowData.CarRequestID; 

        recordfile.push(rowData.NumberRequestID);
        lastrecordfile = rowData.NumberRequestID;

        recordsum.push(rowData.Seat);
        lastrecordsum = rowData.Seat; 

        record_sday.push(rowData.FromDate);
        lastrecord_sday = rowData.FromDate;
        
        record_eday.push(rowData.ToDate);
        lastrecord_eday = rowData.ToDate;
        //console.log(record_sday);
        //console.log(record_eday);
    });

    $("#grid").on('rowunselect', function (event) {   
        var args = event.args;
        var rowBoundIndex = args.rowindex;
        var rowData = args.row;
        var index = record.indexOf(rowData.CarRequestID);
        if (index > -1) {
            record.splice(index, 1);
        }

        var index = recordsum.indexOf(rowData.Seat);
        if (index > -1) {
            recordsum.splice(index, 1);
        }

        var index = record_sday.indexOf(rowData.FromDate);
        if (index > -1) {
            record_sday.splice(index, 1);
        }

        var index = record_eday.indexOf(rowData.ToDate);
        if (index > -1) {
            record_eday.splice(index, 1);
        }
        //console.log(record_sday);
        //console.log(record_eday);
    });


    //gridrow2
    $("#grid2").on('rowselect', function (event) {
        var args = event.args;
        var rowBoundIndex = args.rowindex;
        var rowData = args.row;
        record2.push(rowData.CarRequestID);
        lastrecord2 = rowData.CarRequestID; 

        recordsum2.push(rowData.Seat);
        lastrecordsum2 = rowData.Seat; 
    });

    $("#grid2").on('rowunselect', function (event) {   
        var args = event.args;
        var rowBoundIndex = args.rowindex;
        var rowData = args.row;
        var index = record2.indexOf(rowData.CarRequestID);
        if (index > -1) {
            record2.splice(index, 1);
        }

        var index = recordsum2.indexOf(rowData.Seat);
        if (index > -1) {
            recordsum2.splice(index, 1);
        }
            var sum = recordsum2.reduce(add, 0);
                function add(a, b) {
                    return (b - a);
                }
            //console.log(sum);
            $('#eeseat').val(sum);
    });

    $("#grid2").on('rowselect', function (event) {
        var sum = recordsum2.reduce(add, 0);
            function add(a, b) {
                return a + b;
            }
        //console.log(sum);
        $('#eeseat').val(sum);
    });

    //gridrow3
    $("#grid3").on('rowselect', function (event) {
        var args = event.args;
        var rowBoundIndex = args.rowindex;
        var rowData = args.row;
        record3.push(rowData.CarRequestID);
        lastrecord3 = rowData.CarRequestID; 

        recordsum3.push(rowData.Seat);
        lastrecordsum3 = rowData.Seat; 
    });

    $("#grid3").on('rowunselect', function (event) {   
        var args = event.args;
        var rowBoundIndex = args.rowindex;
        var rowData = args.row;
        var index = record3.indexOf(rowData.CarRequestID);
        if (index > -1) {
            record3.splice(index, 1);
        }

        var index = recordsum3.indexOf(rowData.Seat);
        if (index > -1) {
            recordsum3.splice(index, 1);
        }
            var sum3 = recordsum3.reduce(add, 0);
                function add(a, b) {
                    return (b - a);
                }
            //console.log(sum);
            $('#eeeseat').val(sum3);
    });

    $("#grid3").on('rowselect', function (event) {
        var sum3 = recordsum3.reduce(add, 0);
            function add(a, b) {
                return a + b;
            }
        //console.log(sum);
        $('#eeeseat').val(sum3);
    });

    //Add Request
    var record_request =[];
    var lastrecord_request; 
    var recordsum_request =[];
    var lastrecordsum_request;

    var request_source =
    {
        datatype: "json",
        url : './cartransmanage',
        datafields: [
            { name: 'CarRequestID', type: 'int' },
            { name: 'NumberRequestID', type: 'string' },
            { name: 'FromDate', type: 'date' },
            { name: 'ToDate', type: 'date' },
            { name: 'FromTime', type: 'time'},
            { name: 'ToTime', type: 'time'},
            { name: 'Seat', type: 'int'},
            { name: 'Start', type: 'string'},
            { name: 'StartingPoint', type: 'string'},
            { name: 'Finished', type: 'string'},
            { name: 'Title', type: 'string'},
            { name: 'StatusID', type: 'int'},
            { name: 'CreateBy', type: 'int'},
            { name: 'NameMg', type: 'string'},
            { name: 'Name', type: 'string'},
            { name: 'StatusName', type: 'string'},
            { name: 'InternalCode', type: 'string'}

        ]
    };

    var request_adapter = new $.jqx.dataAdapter(request_source);

    $("#grid_request").jqxGrid(
    {
        width: '100%',
        source: request_adapter,  
        columnsresize: true,
        pageable: true,
        autoHeight: true,
        filterable: true,
        showfilterrow: true,
        enableanimations: false,
        altrows: true,
        sortable: true,
        pagesize: 3,
        selectionmode: 'checkbox',
        theme : theme_s,
        columns: [
            {text: 'รายการ',datafield: 'CarRequestID',width: 60},
            {text: 'วันที่ใช้รถ',datafield: 'FromDate',filtertype: 'range',cellsformat: 'dd-MM-yyyy',width: 80},
            {text: 'เวลารถออก',datafield: 'FromTime',width: 80},
            {text: 'ใช้รถถึงวันที่',datafield: 'ToDate',filtertype: 'range',cellsformat: 'dd-MM-yyyy',width: 80},
            {text: 'เวลารถกลับ',datafield: 'ToTime',width: 80},
            {text: 'จุดประสงค์การใช้รถ',datafield: 'Title',width: 200},
            {text: 'ผู้โดยสาร',datafield: 'Seat',width: 70},
            {text: 'ต้นทาง',datafield: 'InternalCode',width:120, 
                cellsrenderer: function (index, datafield, value, defaultvalue, column, rowdata){
                var status;
                status =  "<div style='padding: 5px; background:#00BB00 ; color:#ffffff;'>"+value+"</div>";
                return status;
                }
            },

            {text: 'ปลายทาง',datafield: 'Finished',width: 120,
                cellsrenderer: function (index, datafield, value, defaultvalue, column, rowdata){
                var status;
                status =  "<div style='padding: 5px; background:#EE0000 ; color:#ffffff;'>"+value+"</div>";
                return status;
                }
            },
            {text: 'จุดขึ้นรถ',datafield: 'StartingPoint',width: 120},
            {text: 'Status',datafield: 'StatusName',filtertype: 'checkedlist',width: 80},
            {text: 'สร้างโดย',datafield: 'Name',width: 120},
            {text: 'อนุมัติโดย',datafield: 'NameMg',width: 120},
            
        ]
    });

    $('#dialog_addrequest').on('close', function (event) {
        location.reload();
    });
    $("#R_eselectcar").on('click',function(){
        $('#dialogecar').jqxWindow('open');
    });
    $("#R_eselectdriver").on('click',function(){
        $('#dialogedriver').jqxWindow('open');
    });

    $('#dialog_addrequest').jqxWindow({
        maxWidth: 1000,
        maxHeight: 1000,
        width : 900,
        height : 650,
        autoOpen : false,
        isModal : true,
        theme : theme_s   
    });

    $("#add_request").on('click', function () {
        var selectedrowindex = $("#gridtrans").jqxGrid('getselectedrowindex');
        var datarow = $("#gridtrans").jqxGrid('getrowdata', selectedrowindex);

        if (typeof datarow !== 'undefined') {

            $('#dialog_addrequest').jqxWindow('open');
            $('#save_request').prop('disabled', true);
            LoadGird3(datarow.CarRequestID);           
            $('#title_car').text("Cancel");

            var ecarid = datarow.CarID;
            var url = "./checkedcar?carid="+ecarid;
            $.get(url, function(data){
                //console.log(data);
                $('#R_eseatcar').val(data);
            });

            $('#R_eid_approve').val(datarow.CarApproveID);
            $('#R_eid_request').val(datarow.CarRequestID);
            $('#R_ecarid').val(datarow.CarID);
            $('#R_ecarname').val(datarow.CarRegistration);
            $('#R_edriverid').val(datarow.DriverID);
            $('#R_edrivername').val(datarow.DriverName);
            $('#R_eseat').val(datarow.Seat);
            $('#R_etxtremark').val(datarow.Remark);
            
                time = datarow.StartTime;
                timeArray = time.split(":",-1);
                $('#R_estartTime').val(timeArray[0]+":"+timeArray[1]);
                time = datarow.EndTime;
                timeArray = time.split(":",-1);
                $('#R_eendTime').val(timeArray[0]+":"+timeArray[1]);
               
                $('#R_edatestart').val(datarow.StartDate);
                $('#R_edateend').val(datarow.EndDate);

        } 
    });

    $('#addrequest').submit(function(e){
        e.preventDefault();
        // $('#saverequest').prop('disabled',true);
        var R_eseatSum = $('#R_eseatSum').val();
        // if (R_eseatSum < 0) {
        //     R_eseatSum = parseInt(R_eseatSum)*parseInt(-1);
        // }
        // var R_eseat = $('#R_eseat').val();
        // R_Total = parseInt(R_eseat)+parseInt(R_eseatSum);
        
        // $('#R_eseat').val(R_Total);
        // alert(R_Total);
        Ra_id = $('#R_eid_approve').val();
        Rc_id = $('#R_eid_request').val();
        Recarid = $('#R_ecarid').val();
        Redriverid = $('#R_edriverid').val();
        Redatestart = $('#R_edatestart').val();
        Redateend = $('#R_edateend').val();
        RestartTime = $('#R_estartTime').val();
        ReendTime = $('#R_eendTime').val();
        Retxtremark = $('#R_etxtremark').val();
        Re_seat = $('#R_eseat').val();
        Rsum_row = $('#R_eeseat').val();

        if (record_request!="") {
            comma = ",";
        }else{
            comma = "";
        }

        record_requestID = (record_request+comma+Rc_id);
        // alert(record_requestID);

        var TIME_PATTERN = /^((2[0-3])|([01][0-9])):[0-5][0-9]$/;
        var x = $('#R_eseatcar').val();
        var a1=parseFloat(Re_seat);
        var a2=parseFloat($('#R_eeseat').val());
        y=a1+a2;

        if(Redatestart > Redateend){
            gotify("กรุณากรอก วันที่ให้ถูกต้อง","danger")
        }else if($.trim(RestartTime)==''){
            gotify("กรุณากรอก เวลา","danger")
        }else if (TIME_PATTERN.test(RestartTime)===false){
            gotify("กรุณาช็ครูปแบบเวลา (ตัวอย่าง 08:00)","danger")
        }else if($.trim(ReendTime)==''){
            gotify("กรุณากรอก เวลา","danger")
        }else if (TIME_PATTERN.test(ReendTime)===false){
            gotify("กรุณาช็ครูปแบบเวลา (ตัวอย่าง 08:00)","danger")
        }else if(parseFloat(x) < parseFloat(y)){
             gotify("จำนวนที่นั่งไม่พอสำหรับจำนวนผู้โดยสาร","danger")
        }else if(parseFloat($('#R_eseat').val()) > parseFloat(x)){
             gotify("จำนวนที่นั่งไม่พอสำหรับจำนวนผู้โดยสาร","danger")
        }else{

        // console.log('ไอดี=>'+Ra_id+'\nรายละเอียด=>'+Retxtremark+'\nที่นั่ง=>'+Re_seat+'\nไอดี=>'+record_requestID+'\nเวลา=>'+RestartTime+'^'+ReendTime+'\nไอดีรถ=>'+Recarid+'\nไอดีคนขับ=>'+Redriverid);
        // alert(record_requestID);
            $.ajax({
                url : './updatehradminmanage_request',
                type : 'post',
                data : {
                  Ra_id : Ra_id,
                  Retxtremark : Retxtremark,
                  Re_seat : Re_seat,
                  record_requestID : record_requestID,
                  RestartTime : RestartTime,
                  ReendTime : ReendTime,
                  Recarid : Recarid,
                  Redriverid : Redriverid
                },
                success : function(data){
                    // alert(data);
                    if (data==1) {
                        gotify("บันทึกสำเร็จ","success")
                    }else if(data==11){
                        gotify("รถคันนี้ถูกใช้งานไปแล้ว","danger")
                    }else{
                        gotify("เกิดข้อผิดพลาด","danger")
                    }
                    
                    $('#dialog_addrequest').jqxWindow('close');
                }
            });

        }

    });

    $("#grid_request").on('rowselect', function (event) {
        var args = event.args;
        var rowBoundIndex = args.rowindex;
        var rowData = args.row;
        record_request.push(rowData.CarRequestID);
        lastrecord_request = rowData.CarRequestID; 

        recordsum_request.push(rowData.Seat);
        lastrecordsum_request = rowData.Seat; 
        
        var sum_request = recordsum_request.reduce(add, 0);
            function add(a, b) {
                return a + b;
            }
        origin = $('#R_eseat').val();

        $('#R_eseatSum').val(sum_request);
        $('#R_eseat').val(parseInt(origin)+parseInt(rowData.Seat));
    });

    $("#grid_request").on('rowunselect', function (event) {   
        var args = event.args;
        var rowBoundIndex = args.rowindex;
        var rowData = args.row;
        var index = record_request.indexOf(rowData.CarRequestID);
        if (index > -1) {
            record_request.splice(index, 1);
        }
        
        var index = recordsum_request.indexOf(rowData.Seat);
        if (index > -1) {
            recordsum_request.splice(index, 1);
        }

        var sum_request = recordsum_request.reduce(add, 0);
        
        function add(a, b) {
            return (a - b);
        }
        origin = $('#R_eseat').val();
 
        $('#R_eseatSum').val(sum_request);
        $('#R_eseat').val(parseInt(origin)-parseInt(rowData.Seat));
       
    });

</script>