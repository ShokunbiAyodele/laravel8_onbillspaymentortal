@extends('admin.admin_master')

@section('admin')

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

    <td><h2>GOTV suscription Payment Confirmation</h2>
    <p>Customer Name: {{ $selectGotveDetails->firstName}} </p>
    <p>Email: {{$selectGotveDetails->email}}</p>
    </td>
  </tr>


  </table>
 
<table id="customers">
  <tr>
    <th>SN</th>
    <th>GOTV Details</th>
    <th>Data</th>
  </tr>
  <tr>
    <td>1</td>
    <td>Package name</td>
    <td>{{  $selectGotveDetails['gotv_packe_name']['name'] }}</td>
  </tr>

  <tr>
    <td>2</td>
    <td>SmartCard No</td>
    <td>{{  $selectGotveDetails['smartCard'] }}</td>
  </tr>

  <tr>
    <td>3</td>
    <td>Amount</td>
    <td>{{ '#'.number_format($selectGotveDetails['amount'],2)}}</td>
  </tr>

  <tr>
    <td>4</td>
    <td>Customer No</td>
    <td>{{  $selectGotveDetails['customerNumber'] }}</td>
  </tr>

  <tr>
    <td>5</td>
    <td>Date Due</td>
    <td>{{  $selectGotveDetails['dueDate'] }}</td>
  </tr>
</table>
<hr>

</body>
</html>


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
    window.location.href = "http://localhost/Ebill/services/public/get/gotv_pdf_details";
  }
  else{
    window.location.href = "http://localhost/Ebill/services/public/dashboard";
  }
});

})


</script>
@endsection