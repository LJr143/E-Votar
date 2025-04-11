<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Election Records</title>
</head>
<body>

<table style="width: 100%; border-collapse: collapse;">
    <thead>
    <tr>
        <th colspan="6" style="font-size: 14px; padding: 15px; height: 110px; text-align: center; vertical-align: middle; font-weight: 700; color: white;">

        </th>
    </tr>
    <tr>
        <th style="font-size: 12px; border: 1px solid black; padding: 5px; height: 30px; vertical-align: middle; text-align: left; background-color: #970707; font-weight:700; color: white">Election Id</th>
        <th style="font-size: 12px; border: 1px solid black; padding: 5px; height: 30px; vertical-align: middle; text-align: left; background-color: #970707; font-weight:700; color: white">Election Name</th>
        <th style="font-size: 12px; border: 1px solid black; padding: 5px; height: 30px; vertical-align: middle; text-align: left; background-color: #970707; font-weight:700; color: white">Election Slug</th>
        <th style="font-size: 12px; border: 1px solid black; padding: 5px; height: 30px; vertical-align: middle; text-align: left; background-color: #970707; font-weight:700; color: white">Election Type </th>
        <th style="font-size: 12px; border: 1px solid black; padding: 5px; height: 30px; vertical-align: middle; text-align: left; background-color: #970707; font-weight:700; color: white">Election Campus</th>
        <th style="font-size: 12px; border: 1px solid black; padding: 5px; height: 30px; vertical-align: middle; text-align: left; background-color: #970707; font-weight:700; color: white">Start Date</th>
        <th style="font-size: 12px; border: 1px solid black; padding: 5px; height: 30px; vertical-align: middle; text-align: left; background-color: #970707; font-weight:700; color: white">End Date</th>
    </tr>
    </thead>
    <tbody>
    @foreach($elections as $election)
        <tr>
            <td style="font-size: 10px; border: 1px solid black; text-align: left; height: 30px; vertical-align: middle; color: #000000">
                {{ ucfirst($election->id) }}
            </td>
            <td style="font-size: 10px; border: 1px solid black; text-align: left; height: 30px; vertical-align: middle; color: #000000">
                {{ ucfirst($election->name) }}
            </td>

            <td style="font-size: 10px; border: 1px solid black; text-align: left; height: 30px; vertical-align: middle;">{{ ucfirst($election->slug) }}</td>
            <td style="font-size: 10px; border: 1px solid black; text-align: left; height: 30px; vertical-align: middle;">{{ ucfirst($election->election_type->name) }}</td>
            <td style="font-size: 10px; border: 1px solid black; text-align: left; height: 30px; vertical-align: middle;">{{ ucfirst($election->campus->name) }}</td>
            <td style="font-size: 10px; border: 1px solid black; text-align: left; height: 30px; vertical-align: middle;">{{ ucfirst($election->date_started) }}</td>
            <td style="font-size: 10px; border: 1px solid black; text-align: left; height: 30px; vertical-align: middle;">{{ ucfirst($election->date_ended) }}</td>

        </tr>
    @endforeach
    </tbody>
</table>
</body>
</html>
