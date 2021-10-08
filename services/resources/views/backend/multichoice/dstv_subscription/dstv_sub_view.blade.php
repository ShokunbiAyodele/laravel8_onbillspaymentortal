@extends('admin.admin_master')

@section('admin')
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>



<div class="container">
<form method="POST" action="{{ route('dstvSubscription_purchase') }}">
            @csrf
    <div class="card">
      <div class="card-body"><b>DSTV CUSTOMER DETAILS</b></div><br>
        <div class="row">  
          <div class="col-md-3">
             <div class="form-group">
              <label>Customer Smart Card No</label>
              <input type="text" name="smartCard" class="form-control" required="">
            </div>
         </div>

        
          <div class="col-md-3">
             <div class="form-group">
             <label>Select Product</label>
               <select name="productsCode" class="form-control" id="productsCode">
               <option value="" >select product</option>
               @foreach($DstvDetails as $eachDstv)
               <option  value="{{$eachDstv['code']}}" >{{ $eachDstv['name'] }}</option>
               @endforeach
               </select>
            </div>
          </div>
         <div class="col-md-2">
            <div class="form-group">
              <label>Amount</label>
              <input type="number" name="amount" id="amount" value=""  class="form-control" placeholder="NGN">
            </div>
         </div>
        
         <div class="col-md-4">
            <div class="form-group">
              <label>Mobile Number</label>
              <input type="text" name="phone"  class="form-control" required="">
            </div>  
         </div>
         </div>

          <div class="row" style="display:none" id="show-addon">
            <div class="col-md-3">
                <div class="form-group">
                  <label>Change Package</label>
                  <select  class="form-control" name="productCode" id="change_package">
                    <option value="">select package</option>
                  </select>
                </div>  
            </div>
              <div class="col-md-3" style="padding-top: 25px; display:none" id="show-amount">
                <div class="form-group">
                <input type="number" name="other_amount" value=""  class="form-control" id="package-amount">
                </div>  
             </div>

             <div class="col-md-3">  
            </div>
            <div class="col-md-3">  
            </div>
          </div>
        
       </div>
    <input type="submit" class="btn btn-rounded btn-primary" value="Make Payment">
    </div>
  </form>
</div>
<!-- sweetalert2 javascript -->
<script src="//cdn.jsdelivr.net/npm/sweetalert2@10"></script>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>


  <script type="text/javascript">

  $(document).on('change','#productsCode',function(){
    let productsCode = $('#productsCode').val();
    $.ajax({
    
      url : "{{ route('get_dstv_amount') }}",
      type : "GET",
      data: {'productsCode':productsCode},

      success : function(data){
       $('#amount').val(data);
      }

    })
  })


$(document).on('change','#productsCode',function(){
  let ProductAddons = $('#productsCode').val(); 
 
  Swal.fire({
  title: 'do you want to?',
  text: "select another package!",
  icon: 'warning',
  showCancelButton: true,
  confirmButtonColor: '#3085d6',
  cancelButtonColor: '#d33',
  confirmButtonText: 'Yes!'
}).then((result) => {
  if (result.isConfirmed) {
	 $.ajax({
    url :"{{ route('get_dstv_ProductaddonPackage') }}",
    type : "get",
    data: {'ProductAddons': ProductAddons},
    success : function(data){
     data.forEach(function(value){
        $('#show-addon').show();
      let html = `<option value="${value.code}">${value.name}</option>`;
      $('#change_package').append(html);    
    
     })
       
    }

  })
       $('#productsCode').val(' ');
       $('#amount').val(' ');
       $('#productsCode').attr('disabled','true');
       document.getElementById('amount').disabled = true;

  }
});


});

$(document).on('change','#change_package',function(){
    let amountcode = $('#change_package').val();
    $.ajax({
    
      url : "{{ route('get_dstv_packageamount') }}",
      type : "GET",
      data: {'amountcode':amountcode},
      success : function(data){
        $('#show-amount').show();
       $('#package-amount').val(data);
      }

    })
  })



  </script>

@endsection





