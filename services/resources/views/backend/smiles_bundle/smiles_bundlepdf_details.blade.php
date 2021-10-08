
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

    <td><h5>Smiles Recharge suscription Payment Receipt</h5>
    <p>Customer Name: {{ $pdf_details->customerName}} </p>
    <p>Email: {{$pdf_details->email}}</p>
    </td>
  </tr>


  </table>

 
<table id="customers">
  <tr>
    <th>SN</th>
    <th>Smiles Details</th>
    <th>Data</th>
  </tr>


  <tr>
    <td>1</td>
    <td>SmartCard No</td>
    <td>{{  $pdf_details['accountId'] }}</td>
  </tr>
  <tr>
    <td>2</td>
    <td>Status</td>
    <td>{{  $pdf_details['status'] }}</td>
  </tr>

  <tr>
    <td>3</td>
    <td>Amount</td>
    <td>{{ '#'.number_format($pdf_details['amount'],2)}}</td>
  </tr>

  <tr>
    <td>4</td>
    <td>Exchange Reference</td>
    <td>{{ $pdf_details['exchangeReference']  }}</td>
  </tr>

  <tr>
    <td>5</td>
    <td>Transaction Number</td>
    <td>{{ $pdf_details['transactionNumber']  }}</td>
  </tr>

  <tr>
    <td>6</td>
    <td>Transaction Date</td>
    <td>{{ $pdf_details['transactionDate']}}</td>
    
  </tr>
  

  
</table>
<hr>

</body>
</html>