@extends('admin.admin_master')

@section('admin')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<!DOCTYPE html>
<html>
<head>
<style>
#customers {
  font-family: Arial, Helvetica, sans-serif;
  border-collapse: collapse;
  width: 80%;
  align: center;
}

#customers td, #customers th {
  border: 1px solid #ddd;
  padding: 8px;
  align: center;
}

#customers tr:nth-child(even){background-color: #f2f2f2;}

#customers tr:hover {background-color: #ddd;}

#customers th {
  padding-top: 12px;
  padding-bottom: 12px;
  text-align: left;
  background-color: #006a00;
  color: white;
}
</style>
</head>
<body>

<table id="customers" width="50%">
<tr>

    <td><h5>Ibadan Postpaid Electricity Receipt</h5>
    <p>Customer Name: {{ $selectAbujaPostPaid->customerName}} </p>
    <p>Email: {{$selectAbujaPostPaid->email}}</p>
    </td>
  </tr>


  </table>
 
<table id="customers">
  <tr>
    <th>SN</th>
    <th>Details</th>
    <th>Data</th>
  </tr>

  <tr>
    <td>1</td>
    <td>Account Number</td>
    <td>{{  $selectAbujaPostPaid['accountNumber'] }}</td>
  </tr>
  <tr>
    <td>2</td>
    <td>Status</td>
    <td>{{  $selectAbujaPostPaid['status'] }}</td>
  </tr>

  <tr>
    <td>3</td>
    <td>Amount</td>
    <td>{{ '#'.number_format($selectAbujaPostPaid['amount'],2)}}</td>
  </tr>

  <tr>
    <td>4</td>
    <td>Exchange Reference</td>
    <td>{{ $selectAbujaPostPaid['exchangeReference']}}</td>
  </tr>
  

  
</table>
<hr>

</body>
</html>
<!-- sweetalert2 javascript -->
<script src="//cdn.jsdelivr.net/npm/sweetalert2@10"></script>


<script type="text/javascript">
$(document).ready(function(){
  Swal.fire({
  title: 'Print',
  text: "Print your receipt!",
  icon: 'info',
  showCancelButton: true,
  confirmButtonColor: '#3085d6',
  cancelButtonColor: '#d33',
  confirmButtonText: 'Yes!'
}).then((result) => {
  if (result.isConfirmed) {
    window.location.href = "http://localhost/Ebill/services/public/get/abujapostpaid_pdf_details";
  }
  else{
    window.location.href = "http://localhost/Ebill/services/public/dashboard";
  }
});


  
})


</script>
@endsection