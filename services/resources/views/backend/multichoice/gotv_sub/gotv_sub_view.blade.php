@extends('admin.admin_master')

@section('admin')
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>



<div class="container">
<form method="POST" action="{{ route('gotvSubscription_purchase') }}">
            @csrf
    <div class="card">
      <div class="card-body"><b>GOTV CUSTOMER DETAILS</b></div><br>
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
               <select name="productsCode" class="form-control" id="productsCode" required="">
               <option value="" >select product</option>
               @foreach($gotvDetails as $gotv)
               <option value="{{$gotv['code']}}" >{{ $gotv['name'] }}</option>
               @endforeach
               </select>
            </div>
          </div>

         <div class="col-md-2">
            <div class="form-group">
              <label>Amount</label>
              <input type="number" name="amount" id="amount" value=""  class="form-control" placeholder="NGN"  required="">
            </div>
         </div>
       
         <div class="col-md-4">
            <div class="form-group">
              <label>Mobile Number</label>
              <input type="text" name="phone"  class="form-control" required="">
            </div>  
         </div>
         

         </div>
        
       </div>
    <input type="submit" class="btn btn-rounded btn-primary" value="Make Payment">
    </div>
  </form>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>


  <script type="text/javascript">

  $(document).on('change','#productsCode',function(){
    let productsCode = $('#productsCode').val();
    $.ajax({
    
      url : "{{ route('get_gotv_amount') }}",
      type : "GET",
      data: {'productsCode':productsCode},
      success : function(data){
       $('#amount').val(data);
      }

    })
  })


  </script>

@endsection





