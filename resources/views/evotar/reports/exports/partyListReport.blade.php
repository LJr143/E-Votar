<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Party List Records</title>
</head>
<body>

<table style="width: 100%; border-collapse: collapse;">
    <thead>
    <tr>
        <th colspan="6" style="font-size: 14px; padding: 15px; height: 110px; text-align: center; vertical-align: middle; font-weight: 700; color: white;">

        </th>
    </tr>
    <tr>
        <th style="font-size: 12px; border: 1px solid black; padding: 5px; height: 30px; vertical-align: middle; text-align: left; background-color: #970707; font-weight:700; color: white">Party List ID</th>
        <th style="font-size: 12px; border: 1px solid black; padding: 5px; height: 30px; vertical-align: middle; text-align: left; background-color: #970707; font-weight:700; color: white">Name</th>
    </tr>
    </thead>
    <tbody>
    @foreach($party_lists as $party_list)
        <tr>
            <td style="font-size: 10px; font-weight: bold; border: 1px solid black; text-align: left; height: 30px; vertical-align: middle; color: #000000">
                {{ ucfirst($party_list->id) }}
            </td>
            <td style="font-size: 10px; font-weight: bold; border: 1px solid black; text-align: left; height: 30px; vertical-align: middle;">
                {{ ucfirst($party_list->name) }}
            </td>

        </tr>
    @endforeach
    </tbody>
</table>
</body>
</html>
