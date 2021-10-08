@extends('admin.admin_master')

@section('admin')
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">


<div class="container">
<form method="POST" action="{{ route('smiles.rechardge') }}">
            @csrf
    <div class="card">
      <div class="card-body"><b>SMILES PURCHASE DETAILS</b></div><br>
        <div class="row">  
          <div class="col-md-4">
             <div class="form-group">
              <label>Customer Meter No</label>
              <input type="text" id="accountId" name="accountId" class="form-control" required="">
            </div>
         </div>
         <div class="col-md-2">
            <div class="form-group">
              <label>Amount</label>
              <input type="number" id="amount" name="amount"  class="form-control" placeholder="NGN"  required="">
            </div>
         </div>
         <div class="col-md-3">
           <div class="form-group">
              <label>Mobile Number</label>
              <input type="text" id="phone" name="phone"  class="form-control" required="">
            </div>
         </div>

         <div class="col-md-3">
         </div>

         </div>
        
       </div>
    <input type="submit" class="btn btn-rounded btn-primary" value="Make Payment">
    </div>
  </form>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

@endsection





