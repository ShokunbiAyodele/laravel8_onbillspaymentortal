@extends('admin.admin_master')

@section('admin')
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">


<div class="container">
<form method="POST" action="{{ route('smiles.bundle') }}">
            @csrf
    <div class="card">
      <div class="card-body"><b>SMILES BUNDLE PURCHASE DETAILS</b></div><br>
        <div class="row">  
          <div class="col-md-4">
             <div class="form-group">
              <label>Customer Account Id</label>
              <input type="text" id="accountId" name="accountId" class="form-control" required="">
            </div>
         </div>
         <div class="col-md-3">
            <div class="col-md-3" style="padding-top: 25px">
            <input type="button" id="get-bundle" class="btn btn-rounded btn-primary" value="Get Bundle">
            </div>
            </div>

         <div class="col-md-2">
            <div class="form-group">
              <label>Amount</label>
              <select name="amount" class="form-control" id="select-amount">
                <option value="">Select Bundle</option>

              </select>

              <!-- <input type="number" id="amount" name="amount"  class="form-control" placeholder="NGN"  required=""> -->
            </div>
         </div>

         <div class="col-md-3">
           <div class="form-group">
              <label>Mobile Number</label>
              <input type="text" id="phone" name="phone"  class="form-control" required="">
            </div>
         </div>
         </div>
        
       </div>
    <input type="submit" style="display: none" id="submit" class="btn btn-rounded btn-primary" value="Make Payment">
    </div>
  </form>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>


  <script type="text/javascript">
$(document).on('click','#get-bundle',function(){
  let accountId = $('#accountId').val().trim();
  $.ajax({
     url : "{{ route('get_bundle_package') }}",
    type : "GET",
    data : {'accountId':accountId},
    success : function(data){
      data.forEach(function(value){
       
        let html = `<option value="${value.amount}">${value.description} ${value.amount}</option>`;
        $('#select-amount').append(html);
        $('#submit').show();
        $('#get-bundle').hide();

      })
    }
  })

})


</script>

@endsection





