@extends('template.app')
@section('css_bottom')

@endsection
@section('body')
<div class="container-fluid course-wrapper bg1 nomargin">
  <div class="row mt-sm">
    <div class="container">
      <div class="col-md-12">
        <div class="row">
          <div class="content-box-fullwidth">
            @include('customer.nav_bar')
            <div class="col-lg-9">
              <div class="content-head">
                <h4><i class="fa fa-table"></i>View Received Quotes</h4>
              </div>
              <div class="container-fluid">
                {{--*/ $type_id = "" /*--}}
                <div class="row">
                  @if($submited_quote)
                  <?php
                  $i = 1;
                  $j = 1;
                  ?>
                  @foreach($submited_quote as $k => $v)
                  @foreach($v as $key=>$value)
                  @if($j==1)
                  {{--*/ $type_id = $value->type_id /*--}}
                  <div class="col-xs-12 form-horizontal">
                    <div class="col-md-6">
                      <div class="row mt-xs">
                        <div class="col-md-6 text-right"><b>Request ID :</b></div>
                        <div class="col-md-6">{{$value->random_request_id}}</div>
                      </div>
                      <div class="row mt-xs">
                        <div class="col-md-6 text-right"><b>Business Type :</b></div>
                        <div class="col-md-6">{{$value->type_id == 1?"Business":"Residential"}}</div>
                      </div>
                      <div class="row mt-xs">
                        <div class="col-md-6 text-right"><b>SP Tariff :</b></div>
                        <div class="col-md-6">{{$sp_tariff->value}} $/kWh</div>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="row mt-xs">
                        <div class="col-md-6 text-right"><b>Premise :</b></div>
                        <div class="col-md-6">{{$value->premise_address}}</div>
                      </div>
                      @if($type_id == 2)
                      <div class="row mt-xs">
                        <div class="col-md-6 text-right"><b>Type of Dwellings :</b></div>
                        <div class="col-md-6">{{$value->dwe_name}} {{$value->dwe_detail}}</div>
                      </div>
                      @endif
                      <div class="row mt-xs">
                        <div class="col-md-6 text-right"><b>Average Consumption :</b></div>
                        <div class="col-md-6">{{$value->avr_consumtion}} kWh</div>
                      </div>
                    </div>
                  </div><br>
                  <div class="col-xs-12 form-horizontal"><hr>
                    <table class="table-bordered table table-striped basic-table">
                      <col width="">
                      <col width="120">
                      <thead>
                        <tr>
                          <th>S/N</th>
                          <th>Retailer</th>
                          <th>$/kWh for SP Tariffs</th>
                          <th>Price Model</th>
                          <th>Contract Period</th>
                          <th>Amount Saved Per month</th>
                          <th>% Savings</th>
                          <th>Ranking</th>
                          <th>Promotions</th>
                          <th>Detail</th>
                        </tr>
                      </thead>
                      <tbody>
                        <input type="hidden" name="type_id" id="type_id" value="{{$value->type_id}}">
                        @endif
                        <tr>
                          <td>{{$id++}}</td>
                          <td>{{$value->firstname.' '.$value->lastname}}</td>
                          <td>{{$sp_tariff->value}}</td>
                          <td style="width: 15%;" class="price_models">{{$value->name}}</td>
                          <td style="width: 11%;" id="contract_period">{{$value->count_month}} Months</td>
                          <td class="est_amount_save" id="est_amount_save">
                            @if($type_id==1)
                              @if($value->type=="F")
                               $ {{$value->avr_consumtion*($sp_tariff->value - $value->peak)}}
                              @else
                                $ {{number_format($value->avr_consumtion*($sp_tariff->value -($value->peak/100)),2)}}
                              @endif  
                            @else
                              @if($value->type=="F")
                                 $ {{number_format(($value->avr_consumtion*($sp_tariff->value - $value->qprice)),2)}}
                              @else
                                $ {{number_format($value->avr_consumtion*($sp_tariff->value - ($value->qprice/100)),2)}}
                              @endif
                            @endif
                          </td>
                          <td>
                            @if($type_id==1)
                              @if($value->type=="F")
                                {{number_format(((($sp_tariff->value - $value->peak)/$sp_tariff->value)*100),2)}} %
                              @else
                                {{number_format((($value->peak)/100 * $value->avr_consumtion * $sp_tariff->value) ,2)}} %
                              @endif
                            @else
                              @if($value->type=="F")
                                {{number_format(((($sp_tariff->value - $value->qprice)/$sp_tariff->value)*100),2)}} %
                              @else
                                {{number_format((($value->qprice)/100 * $value->avr_consumtion * $sp_tariff->value),2)}} %
                              @endif
                            @endif
                          </td>
                          <td>{{$i}}</td>
                          <td>{{$value->title}}</td>
                          <td>
                              <button data-loading-text="<i class=\'fa fa-refresh fa-spin\'></i>" class="btn btn-xs btn-warning btn-condensed btn-edit btn-tooltip" data-rel="tooltip" data-id="{{$value->submit_quotes_id}}" title="Detail">
                                <i class="ace-icon fa fa-edit bigger-120"></i>
                              </button>
                          </td>
                        </tr>
                        <?php
                        $j++;
                        ?>
                        <?php
                        $i++;
                        ?>
                        @endforeach
                        @endforeach

                      </tbody>
                    </table>
                  </div>
                </div>
                @endif
                @if($type_id == 1)
                <div class="mt-xs container-fluid type" id="business">
                  <form id="FormBusiness" class="FormBusiness" enctype="multipart/form-data">
                    <input type="hidden" id="quotes_id" name="quotes_id" value="">
                    <input type="hidden" id="customer_id" name="customer_id" value="">
                    <input type="hidden" id="retailer_id" name="retailer_id" value="">
                    <input type="hidden" id="request_id" name="request_id" value="">
                    <input type="hidden" id="request_estimate_id" name="request_estimate_id" value="">
                    <input type="hidden" id="count_month" name="count_month" value="">
                    <div class="row">
                      <div class="row">
                        <div class='form-group col-sm-3'>
                        <h3><p class="bg-primary retailer_name"></p></h3>
                        </div><!-- ./form-group -->
                        <div class='form-group col-sm-9'>
                        </div><!-- ./form-group -->
                      </div><!-- ./row -->
                      <div class="row">
                        <div class='form-group col-sm-6'>
                          <label for="date_signup" class="control-label">Date of Sign Up</label>
                          <!-- <input type="text" class="form-control" id="date_signup" placeholder="Date of Sign Up"> -->
                          <div class="" data-date="20-12-2017" data-date-format="dd-mm-yyyy">
                            <input class="form-control date_signup" type="text" name="date_signup" id="date_signup" placeholder="YYYY-MM-DD" value="">
                          </div>
                        </div><!-- ./form-group -->
                        <div class='form-group col-sm-6'>
                          <label for="Fixed" class="control-label peak"></label>
                          <div class="input-group">
                            <input type="text" class="form-control" id="peak" placeholder="12 Months Fixed" readonly>
                            <span class="input-group-addon hide" id="percent_peak">%</span>
                          </div>
                        </div><!-- ./form-group -->
                      <div class="row">
                        <div class='form-group col-sm-6'>

                        </div><!-- ./form-group -->
                        <div class='form-group col-sm-6'>
                          <label for="off" class="control-label off-peak"></label>
                          <div class="input-group">
                            <input type="text" class="form-control" id="off_peak" placeholder="12 Months Fixed Off Peak" readonly>
                            <span class="input-group-addon hide" id="percent_peak_off">%</span>
                          </div>
                        </div><!-- ./form-group -->
                      </div><!-- ./row -->
                      <div class="row">
                        <div class='form-group col-sm-6'>
                          <label for="contact" class="control-label">Contract Period</label>
                          <input type="text" class="form-control contract_period" id="contract_period" name="contact_period" placeholder="Contract Period" value="" readonly>
                        </div>
                        <div class='form-group col-sm-6'>
                          <label for="estimated" class="control-label">Estimated amount saved per month</label>
                          <div type="text" class="form-control estimated_save" id="estimated_save" placeholder="Estimated amount saved per month" value="" readonly></div>
                        </div><!-- ./form-group -->
                      </div><!-- ./row -->
                    </div><hr>
                    <div class="row">
                      <div class="row">
                        <div class='form-group col-sm-6'>
                          <label for="payment" class="control-label">Payment Terms</label>
                          <div class="input-group">
                            <input type="text" class="form-control" id="payment" placeholder="Payment Terms" readonly>
                            <span class="input-group-addon" id="basic-addon1">Days</span>
                          </div>
                        </div><!-- ./form-group -->
                        <div class='form-group col-sm-6'>
                          <label for="billing" class="control-label">AMI meter recurring charges</label>
                          <div class="input-group">
                            <input type="text" class="form-control" id="ami" placeholder="Retailer Charge" readonly>
                            <span class="input-group-addon" id="basic-addon3">$/Month</span>
                          </div>
                        </div> <!-- ./form-group -->
                      </div><!-- ./row -->
                      <div class="row">
                        <div class='form-group col-sm-6'>
                          <label for="security" class="control-label">Security Deposit</label>
                          <div class="input-group">
                            <input type="text" class="form-control" id="security" placeholder="Security Deposit" readonly>
                            <span class="input-group-addon" id="basic-addon2">$</span>
                          </div>
                        </div><!-- ./form-group -->
                        <div class='form-group col-sm-6'>
                          <label for="billing" class="control-label">Billing Charges</label>
                          <div class="input-group">
                            <input type="text" class="form-control" id="billing" placeholder="Billing Charges" readonly>
                            <span class="input-group-addon" id="basic-addon3">$/Month</span>
                          </div>
                        </div><!-- ./form-group -->
                      </div><!-- ./row -->
                      <div class="row">
                        <div class='form-group col-sm-6'>
                          <label for="charge" class="control-label">Retailer Charge</label>
                          <div class="input-group">
                            <input type="text" class="form-control" id="retailer_charge" placeholder="Retailer Charge" readonly>
                            <span class="input-group-addon" id="basic-addon4">$/Month</span>
                          </div>
                        </div><!-- ./form-group -->
                        <div class='form-group col-sm-6'>
                          <label for="collection" class="control-label">Collection Charges</label>
                          <div class="input-group">
                            <input type="text" class="form-control" id="collection" placeholder="Collection Charges" readonly>
                            <span class="input-group-addon" id="basic-addon5">$/Month</span>
                          </div>
                        </div><!-- ./form-group -->
                      </div><!--./row mt-xs form-horizontal -->
                      <div class="row">
                        <div class='form-group col-sm-6'>
                          <label for="collection" class="control-label">Promotions</label>
                          <div class="panel panel-default">
                            <div class="panel-heading" id="promotion_title"></div>
                            <div class="panel-body">
                              <div class="form-group">
                                <div class="col-sm-12" id="promotion_detail">
                                  
                                </div>
                              </div>
                            </div>
                          </div>
                          <!-- <button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
                              Click to show promotion detail
                            </button>
                            <div class="collapse" id="collapseExample">
                              <div class="well">
                                xxxxxxxxxxxxxxxx
                              </div>
                            </div> -->
                        </div><!-- ./form-group col-sm-6 -->
                      </div> <!-- ./row -->
                      <div class="row">
                        <div class='form-group col-sm-6 BillImage'>
                          <label for="charge" class="control-label">Upload Lastest Bill</label>
                          <input type="file" class="form-control" name="photo_bill" id="photo_bill">
                          <img id="img_preview" class="img_preview" src="#" alt="your image" style="display: none" />
                        </div>
                        <div class='form-group col-sm-6'>
                          <label for="collection" class="control-label">Upload Premise Owner</label>
                          <input type="file" class="form-control" name="photo_id_card" id="photo_id_card">
                          <img id="premise_owner_image" class="premise_owner_image" src="#" alt="your image" style="display: none" />
                        </div>
                      </div><!--./row mt-xs form-horizontal -->
                      <!-- <div class="row">
                        <div class='form-group col-sm-6'>
                          <div id="photo_bill" orakuploader="on" name="photo_bill[]"></div>
                          <input type="file" name="photo_bill" id="photo_bill">
                        </div>
                        <div class='form-group col-sm-6'>
                          <div id="photo_id_card" orakuploader="on" name="photo_id_card[]"></div>
                          <input type="file" name="photo_id_card" id="photo_id_card">
                        </div>
                      </div> -->
                      <div class="row">
                        <div class="col-sm-6 col-sm-offset-3">
                          <button type="button" class="col-sm-6 btn btn-danger btn-lg">Back</button>
                          <button type="button" class="col-sm-6 btn btn-warning btn-lg select-business">Select Price Plan</button>
                        </div> <!--./col-sm-6 col-sm-offset-3 -->
                      </div> <!--./row-->
                    </div>
                    <div class="modal fade" id="SelectBusinessModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                      <div class="modal-dialog" role="document">
                        <div class="modal-content">
                          <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" id="myModalLabel">Contraction</h4>
                          </div>
                          <div class="modal-body contract">
                            <a href=""><p id="contract"></p></a>
                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Yes, I agree</button>
                          </div>
                        </div>
                      </div>
                    </div>

                  </form>
                </div>
                @else
                <div class="mt-xs container-fluid type" id="residential">
                  <form id="FormResidetail" class="FormResidetail">
                    <input type="hidden" id="quotes_id" name="quotes_id" value="">
                    <input type="hidden" id="customer_id" name="customer_id" value="">
                    <input type="hidden" id="retailer_id" name="retailer_id" value="">
                    <input type="hidden" id="request_id" name="request_id" value="">
                    <input type="hidden" id="request_estimate_id" name="request_estimate_id" value="">
                    <div class="row">
                      <div class='form-group col-sm-6'>
                        <label for="date_signup" class="control-label">Date of Sign Up</label>
                        <div class="" data-date="20-12-2017" data-date-format="dd-mm-yyyy">
                            <input class="form-control date_signup" type="text" name="date_signup" id="date_signup" placeholder="YYYY-MM-DD">
                        </div>
                        <!-- <input type="text" class="form-control" id="date_signup" placeholder="Date of Sign Up"> -->
                      </div><!-- ./form-group -->
                      <div class='form-group col-sm-6'>
                        <label for="Fixed" class="control-label res-price"></label>
                        <div class="input-group">
                            <input type="text" class="form-control" id="Fixed" placeholder="12 Months Fixed" readonly>
                            <span class="input-group-addon hide" id="percent_fixed_res">%</span>
                          </div>
                      </div><!-- ./form-group -->
                    </div><!-- ./row -->
                    <div class="row">
                      <div class='form-group col-sm-6'>
                        <label for="contact" class="control-label">Contract Period</label>
                        <input type="text" class="form-control contract_period" id="contract_period" name="contact_period" placeholder="Contract Period" readonly>
                      </div><!-- ./form-group -->
                      <div class='form-group col-sm-6'>
                        <label for="estimated" class="control-label">Estimated amount saved per month</label>
                        <div type="text" class="form-control estimated_save_res" id="estimated_save_res" placeholder="Estimated amount saved per month" value="" readonly></div>
                      </div><!-- ./form-group -->
                    </div><!-- ./row -->
                    <div class="row">
                      <div class='form-group col-sm-6'>
                        <label for="payment" class="control-label">Payment Terms</label>
                        <div class="input-group">
                          <input type="text" class="form-control" id="payment" placeholder="Payment Terms" readonly>
                          <span class="input-group-addon" id="basic-addon1">Days</span>
                        </div>
                      </div><!-- ./form-group -->
                      <div class='form-group col-sm-6'>
                        <label for="charge" class="control-label">AMI meter recurring charges</label>
                        <input type="text" class="form-control" id="ami" placeholder="Retailer Charge" readonly>
                      </div><!-- ./form-group -->
                    </div><!-- ./row -->
                    <div class="row">
                      <div class='form-group col-sm-6'>
                        <label for="security" class="control-label">Security Deposit</label>
                        <div class="input-group">
                          <input type="text" class="form-control" id="security" placeholder="Security Deposit" readonly>
                          <span class="input-group-addon" id="basic-addon2">$/Month</span>
                        </div>
                      </div><!-- ./form-group -->
                      <div class='form-group col-sm-6'>
                        <label for="billing" class="control-label">Billing Charges</label>
                        <div class="input-group">
                          <input type="text" class="form-control" id="billing" placeholder="Billing Charges" readonly>
                          <span class="input-group-addon" id="basic-addon3">$/Month</span>
                        </div>
                      </div><!-- ./form-group -->
                    </div><!-- ./row -->
                    <div class="row">
                      <div class='form-group col-sm-6'>
                        <label for="charge" class="control-label">Retailer Charge</label>
                        <div class="input-group">
                          <input type="text" class="form-control" id="retailer_charge" placeholder="Retailer Charge" readonly>
                          <span class="input-group-addon" id="basic-addon4">$/Month</span>
                        </div>
                      </div><!-- ./form-group -->
                      <div class='form-group col-sm-6'>
                        <label for="collection" class="control-label">Collection Charges</label>
                        <div class="input-group">
                          <input type="text" class="form-control" id="collection" placeholder="Collection Charges" readonly> 
                          <span class="input-group-addon" id="basic-addon5">$/Month</span>
                        </div>
                      </div><!-- ./form-group -->
                    </div><!--./row mt-xs form-horizontal -->

                    <div class="row">
                      <div class='form-group col-sm-6'>
                        <label for="collection" class="control-label">Promotions</label>
                        <div class="panel panel-default">
                          <div class="panel-heading" id="promotion_title"> xxxx
                            
                          </div>
                          <div class="panel-body">
                            <div class="form-group">
                              <div class="col-sm-12" id="promotion_detail">
                              
                              </div>
                            </div>
                          </div>
                        </div>

                      </div><!-- ./form-group col-sm-6 -->
                    </div> <!-- ./row -->

                    <div class="row">
                        <div class='form-group col-sm-6'>
                          <label for="charge" class="control-label">Upload Lastest Bill</label>
                          <input type="file" class="form-control" name="photo_bill" id="photo_bill">
                          <img id="img_preview" class="img_preview" src="#" alt="your image" style="display: none" />
                        </div><!-- ./form-group -->
                        <div class='form-group col-sm-6'>
                          <label for="collection" class="control-label">Upload Premise Owner</label>
                          <input type="file" class="form-control" name="photo_id_card" id="photo_id_card">
                          <img id="premise_owner_image" class="premise_owner_image" src="#" alt="your image" style="display: none" />
                        </div><!-- ./form-group -->
                      </div><!--./row mt-xs form-horizontal -->

                    <!-- <div class="row">
                      <div class='form-group col-sm-6'>
                        <div id="photo_bill" orakuploader="on" name="photo_bill[]"></div>
                        <input type="file" name="photo_bill" id="photo_bill">
                      </div>
                      <div class='form-group col-sm-6'>
                        <div id="photo_id_card" orakuploader="on" name="photo_id_card[]"></div>
                        <input type="file" name="photo_id_card" id="photo_id_card">
                      </div>
                    </div> -->
                    <div class="row">
                        <div class="col-sm-6 col-sm-offset-3">
                          <button type="button" class="col-sm-6 btn btn-danger btn-lg">Back</button>
                          <button type="button" class="col-sm-6 btn btn-warning btn-lg select-residentail">Select Price Plan</button>
                        </div> <!--./col-sm-6 col-sm-offset-3 -->
                    </div> <!--./row-->
                    <div class="modal fade" id="SelectResidentailModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                      <div class="modal-dialog" role="document">
                        <div class="modal-content">
                          <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" id="myModalLabel">Contraction</h4>
                          </div>
                          <div class="modal-body contract">
                            <a href=""><p id="contract"></p></a>
                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Yes, I agree</button>
                          </div>
                        </div>
                      </div>
                    </div>

                  </form>
                </div>
                @endif
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  @endsection
  @section('js_bottom')
  <script src="{{asset('assets/front/js/dashboard.js')}}"></script>
  <script>
//     function readURL(input) {
//     if (input.files && input.files[0]) {
//         var reader = new FileReader();
//         reader.onload = function (e) {
//             $('#img_preview').attr('src', e.target.result).show();
//         }
//         reader.readAsDataURL(input.files[0]);
//     }
// }
// $("#photo_bill").change(function(){
//     readURL(this);
// });
function readURLPhotoCard(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function (e) {
            $('#premise_owner_image').attr('src', e.target.result).show();
        }
        reader.readAsDataURL(input.files[0]);
    }
}

$("#photo_id_card").change(function(){
    readURLPhotoCard(this);
});

    // $('.date_signup').datetimepicker({
    //     // setDate: new Date(),
    //     format: 'yyyy-mm-dd',
    //     minView: 2,
    //     autoclose : true
    // });
    var d = '{{date("Y-m-d")}}';
      $('.date_signup').val(d);
    var type_id = $('#type_id').val();
    // console.log(type_id);
    var this_id = "";
      $(function() {
        if(type_id==1) {
          this_id = "business";
          $('#'+this_id).hide();
          $('#residential').remove();
        } else if(type_id==2) {
          this_id = "residential";
          $('#'+this_id).hide();
          $('#business').remove();
        } else if(type_id == "") {
          $(".type").empty();
        }
    });

  // $('body').on('click','#date_signup',function(e){
  //     e.preventDefault();
  //     $('#contract_period').val(date ("d/M/Y", strtotime("+1 week", strtotime($('#date_signup').val()))));
  // });
  // $('body').on('change', '.date_signup', function () {
  //       var start = $("#date_signup").val();
  //       var spl = start.split(" ");
  //       var firstDay = new Date(start);
  //       var months   = firstDay.getMonth()+1;
  //       var y = (firstDay.getFullYear()%4 == 0)?"366":"365";
  //       // alert(firstDay.getDate());
  //       // var nextWeek = new Date(firstDay.getTime() + 7);
  //       var nextWeek = new Date(firstDay.getFullYear()+'-'+(months + 1)+'-'+firstDay.getDate());
  //       var NextYear = new Date(nextWeek.getTime() + y * 24 * 60 * 60 * 1000);
  //       $(".contract_period").val(nextWeek.toISOString().split('T')[0] + ' To ' + NextYear.toISOString().split('T')[0] );
  //       // alert(nextWeek.getFullYear() + '-' + nextWeek.getDate() + '-' +(nextWeek.getMonth() + 1) );
  //   });
  

  var id = "";
  $('body').on('click','.btn-edit',function(data){
      // var toYear  = 
      // console.log(toYear);
      // console.log(start);
      // var spl = start.split(" ");
      // var firstDay = new Date(start);
      // var months   = firstDay.getMonth()+1;
      // var y = (firstDay.getFullYear()%4 == 0)?"366":"365";
      // var toMonth = new Date(firstDay.getFullYear()+'-'+(months + 1)+'-'+firstDay.getDate());
      // var nextMonth = toMonth.toISOString().split('T')[0];
      // console.log(date(nextMonth, strtotime('+ get_month')));
      // var NextYear = new Date(toMonth.getTime() + y * 24 * 60 * 60 * 1000);
    if(type_id==1) {
      $('#estimated_save').text($(this).closest('tr').find('#est_amount_save').text());
      $('.peak').text($(this).closest('tr').find('.price_models').text()+'peak');
      $('.off-peak').text($(this).closest('tr').find('.price_models').text()+' off peak');
    } else {
      $('.res-price').text($(this).closest('tr').find('.price_models').text());
      $('#estimated_save_res').text($(this).closest('tr').find('#est_amount_save').text());
      // $("#contract_period").val(toMonth.toISOString().split('T')[0] + ' To ' + NextYear.toISOString().split('T')[0] );
    }
    var btn = $(this);
    data.preventDefault();
    btn.button('loading');
    id = $(this).data('id');
    $.ajax({
      method : "GET",
      url : url_gb+"/Customer/ViewSubmittedSelectPlan/"+id,
      dataType : 'json'
    }).success(function(rec){
      // console.log(rec.request.request_photo);
      if(rec == null) {
        $('#'+this_id).hide();
        btn.button("reset");
      } else {
        var count_month = rec.count_month;
        var start = '{{date("Y-m-d")}}';
        var nextMonth = '{{date("Y-m-d",strtotime('+1 month'))}}';
        var percent = rec.request_estimate.estimate_commencement.type;
        if (percent == "D") {
          $('#percent_peak').removeClass('hide');
          $('#percent_peak_off').removeClass('hide');
          $('#percent_fixed_res').removeClass('hide');
        }else{
          $('#percent_peak').addClass('hide');
          $('#percent_peak_off').addClass('hide');
          $('#percent_fixed_res').addClass('hide');
        }
        $('#'+this_id).show();
        $('#date_signup').val('{{date("Y-m-d")}}');
        $('#quotes_id').val(rec.quotation.id);
        $('.contract_period').val(nextMonth+' to '+rec.count_month);
        $('#retailer_id').val(rec.user.id);
        $('#customer_id').val(rec.customer.id);
        $('#request_id').val(rec.request_id);
        $('#request_estimate_id').val(rec.request_estimate_id);
        $('#peak').val(rec.quotation.peak);
        $('#off_peak').val(rec.quotation.off_peak);
        $('#payment').val(rec.quotation.payment_term);
        $('.retailer_name').text(rec.user.firstname+' '+rec.user.lastname);
        $('#ami').val(rec.quotation.ami);
        $('#security').val(rec.quotation.sucurity_deposit);
        $('#billing').val(rec.quotation.billing_charge);
        $('#retailer_charge').val(rec.quotation.retailer_charge);
        $('#collection').val(rec.quotation.collection_charge);
        $('#Fixed').val(rec.quotation.price);
        $('#promotion_title').text(rec.title);
        $('#promotion_detail').text(rec.detail);
        $('#contract').text(rec.user.contract.contract_name);
        $('#contract').parent('a').prop('href',asset_gb+"uploads/contracts/"+rec.user.contract.file_name).prop('target','_blank');
        $('.BillImage').children().remove();
        for(var i=1;i<=2;i++) {
          if (rec.request.request_photo[i-1]) {
                $('.BillImage').append('<label for="charge" class="control-label">Upload Lastest Bill</label>'+
                '<input type="file" class="form-control photo_bill'+i+'" name="photo_bill'+i+'"><div class="images"></div>'+
                '<img class="img_preview'+i+'" src="'+asset_gb+'uploads/requests/'+rec.request.request_photo[i-1].photo_name+'" alt="your image" style="width: 250px, height:250px;"/></br></br>');
            }else{
                $('.BillImage').append('<label for="charge" class="control-label">Upload Lastest Bill</label>'+
                '<input type="file" class="form-control photo_bill'+i+'" name="photo_bill'+i+'"><div class="images"></div>'+
                '<img class="img_preview'+i+'" src="" alt="your image" width="200px" height="200px" style="width: 250px;height:250px; display:none"/></br></br>');
          }
        }
        // for(var i=0;i<2;i++) {
        //   $('.BillImage').append('<label for="charge" class="control-label">Upload Lastest Bill</label>'+
        //     '<input type="file" class="form-control" name="photo_bill" id="photo_bill"><div class="images"></div>');
        // }
        // $.each(rec.request.request_photo, function(key,val) {
        //   $.each($('div.images'),function(k,v) {
        //     if(k==key){
        //       $(this).append(
        //         '<img id="img_preview" class="img_preview" src="'+asset_gb+'uploads/requests/'+val.photo_name+'" alt="your image"/>');
        //       $(this).closest('.BillImage').find('input[type="file"]').attr('value',val.photo_name);
        //     }
        //   });
        // });
      btn.button("reset");
    }
		}).error(function(){
      $('#'+this_id).hide();
			swal("system.system_alert","system.system_error","error");
			btn.button("reset");
		});
	});

function readURL1(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function (e) {
            $('.img_preview1').attr('src', e.target.result).show();
        }
        reader.readAsDataURL(input.files[0]);
    }
}
$('body').on('change','.photo_bill1', function(){
    $(this).next().next().removeAttr('src');
    readURL1(this);
});
function readURL2(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function (e) {
            $('.img_preview2').attr('src', e.target.result).show();
        }
        reader.readAsDataURL(input.files[0]);
    }
}
$('body').on('change','.photo_bill2', function(){
    $(this).next().next().removeAttr('src');
    readURL2(this);
});

$('body').on('click','.select-business',function(e){
  e.preventDefault();
  $('#SelectBusinessModal').modal('show');
});
$('body').on('click','.select-residentail',function(e){
  e.preventDefault();
  $('#SelectResidentailModal').modal('show');
});

  $('#FormBusiness').validate({
    errorElement: 'span',
    errorClass: 'help-block',
    focusInvalid: false,
    rules: {
      date_signup: {
        required: true,
      },
      contact_period: {
        required: true,
      }
    },
    messages: {
      date_signup: {
        required: 'Please select date sign up',
      },
      contact_period: {
        required: 'Please select contract period',
      }
    },
    highlight: function (e) {
      validate_highlight(e);
    },
    success: function (e) {
      validate_success(e);
    },

    errorPlacement: function (error, element) {
      validate_errorplacement(error, element);
    },
    submitHandler: function (form) {
      var btn = $(form).find('[type="submit"]');
      $('#SelectBusinessModal').modal('hide');
      var formData = new FormData(form);
    // btn.button("loading");
    swal({
      title: "Confirm Price Plan?",
      text:  "Once you’ve confirmed this price plan, you will enter a contract with the selected retailer and price plan. The retailer will contact you directly.",
      type: "warning",
      showCancelButton: true,
      confirmButtonColor: "#DD6B55",
      confirmButtonText: "Confirm",
      cancelButtonText: "Cancel",
      showLoaderOnConfirm: true,
      closeOnConfirm: false
    }, function(data) {
      if(data){
        $.ajax({
          url: url_gb+"/Customer/ViewSubmittedQuotes/SelectPlanBusiness/"+id,
          data: formData,
          type: 'POST',
          contentType: false, // NEEDED, DON'T OMIT THIS (requires jQuery 1.6+)
          processData: false, // NEEDED, DON'T OMIT THIS
          success : function(rec){
            console.log(rec);
            var data = JSON.parse(rec);
            if (data.status == 1) {
              swal({
                position: 'center',
                type: 'success',
                title: data.title,
                text:  data.content,
                showConfirmButton: true
              },function(){
                window.location = url_gb+"/Customer/ViewSubmittedQuotes";
              });
            }else{
              swal({
                position: 'center',
                type: 'error',
                title: data.title,
                text:  data.content,
                showConfirmButton: true
              });
            }
            btn.button('reset');
          }
        });
      }
    });
  },
  invalidHandler: function (form) {

  }
});

$('#FormResidetail').validate({
    errorElement: 'span',
    errorClass: 'help-block',
    focusInvalid: false,
    rules: {
      date_signup: {
        required: true,
      },
      contact_period: {
        required: true,
      }
    },
    messages: {
      date_signup: {
        required: 'Please select date sign up',
      },
      contact_period: {
        required:'Please select contract period',
      }
    },
    highlight: function (e) {
      validate_highlight(e);
    },
    success: function (e) {
      validate_success(e);
    },

    errorPlacement: function (error, element) {
      validate_errorplacement(error, element);
    },
    submitHandler: function (form) {
      var btn = $(form).find('[type="submit"]');
      $('#SelectResidentailModal').modal('hide');
      var formData = new FormData(form);
    // btn.button("loading");
    swal({
      title: "Confirm Price Plan?",
      text:  "Once you’ve confirmed this price plan, you will enter a contract with the selected retailer and price plan. The retailer will contact you directly.",
      type: "warning",
      showCancelButton: true,
      confirmButtonColor: "#DD6B55",
      confirmButtonText: "Confirm",
      cancelButtonText: "Cancel",
      showLoaderOnConfirm: true,
      closeOnConfirm: false
    }, function(data) {
      if(data){
        $.ajax({
          url: url_gb+"/Customer/ViewSubmittedQuotes/SelectPlanResidetail/"+id,
          data: formData,
          type: 'POST',
          contentType: false, // NEEDED, DON'T OMIT THIS (requires jQuery 1.6+)
          processData: false, // NEEDED, DON'T OMIT THIS
          success : function(rec){
            console.log(rec);
            var data = JSON.parse(rec);
            if (data.status == 1) {
              swal({
                position: 'center',
                type: 'success',
                title: data.title,
                text:  data.content,
                showConfirmButton: true
              },function(){
                window.location = url_gb+"/Customer/ViewSubmittedQuotes";
              });
            }else{
              swal({
                position: 'center',
                type: 'error',
                title: data.title,
                text:  data.content,
                showConfirmButton: true
              });
            }
            btn.button('reset');
          }
        });
      }
    });
  },
  invalidHandler: function (form) {

  }
});

  // $('#photo_bill').orakuploader({
  //     orakuploader_path         : url_gb+'/',
  //     orakuploader_ckeditor         : true,
  //     orakuploader_use_dragndrop       : true,
  //     orakuploader_main_path : 'uploads/bills/',
  //     orakuploader_thumbnail_path : 'uploads/bills/',
  //     orakuploader_thumbnail_real_path : asset_gb+'uploads/bills/',
  //     orakuploader_add_image       : asset_gb+'images/add.png',
  //     orakuploader_loader_image       : asset_gb+'images/loader.gif',
  //     orakuploader_no_image       : asset_gb+'images/no-image.jpg',
  //     orakuploader_add_label       : 'Select bill image',
  //     orakuploader_use_rotation: true,
  //     orakuploader_maximum_uploads : 1,
  //     orakuploader_hide_on_exceed : true,
  // });

  // $('#photo_id_card').orakuploader({
  //     orakuploader_path         : url_gb+'/',
  //     orakuploader_ckeditor         : true,
  //     orakuploader_use_dragndrop       : true,
  //     orakuploader_main_path : 'uploads/bills/',
  //     orakuploader_thumbnail_path : 'uploads/bills/',
  //     orakuploader_thumbnail_real_path : asset_gb+'uploads/bills/',
  //     orakuploader_add_image       : asset_gb+'images/add.png',
  //     orakuploader_loader_image       : asset_gb+'images/loader.gif',
  //     orakuploader_no_image       : asset_gb+'images/no-image.jpg',
  //     orakuploader_add_label       : 'Select ID Card Image',
  //     orakuploader_use_rotation: true,
  //     orakuploader_maximum_uploads : 1,
  //     orakuploader_hide_on_exceed : true,
  // });
</script>
  @endsection
