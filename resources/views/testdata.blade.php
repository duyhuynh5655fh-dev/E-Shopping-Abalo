<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Testdaten</title>
    <style>
        table {
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid black;
        }
    </style>
</head>
<body>
<h4>Testdaten</h4>
<table>
    <tr>
        <th>ID</th>
        <th>Testname</th>
    </tr>
    @foreach($testdata as $data)
        <tr>
            <td>{{ $data->id }}</td>
            <td>{{ $data->ab_testname }}</td>
        </tr>
    @endforeach
</table>
</body>
</html>
