<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Program Major Records</title>
</head>
<body>
<table style="width: 100%; border-collapse: collapse;">
    <thead>
    <tr>
        <th colspan="2" style="font-size: 14px; padding: 15px; height: 110px; text-align: center; vertical-align: middle; font-weight: 700; color: white;">

        </th>
    </tr>
    <tr>
        <th style="font-size: 12px; border: 1px solid black; padding: 5px; height: 30px; vertical-align: middle; text-align: left; background-color: #970707; font-weight: 700; color: white;">Program Major ID</th>
        <th style="font-size: 12px; border: 1px solid black; padding: 5px; height: 30px; vertical-align: middle; text-align: left; background-color: #970707; font-weight: 700; color: white;">Program Major Name</th>

    </tr>
    </thead>
    <tbody>
    @foreach($programs as $program)
        <!-- Campus Name Row -->
        <tr>
            <td colspan="2" style="font-size: 12px; font-weight: bold; border: 1px solid black; padding: 5px; height: 30px; vertical-align: middle; text-align: left; background-color: #f0f0f0;">
                {{ ucfirst($program->name) }}
            </td>
        </tr>
        <!-- Colleges under this Campus -->
        @forelse($program->majors as $major)
            <tr>
                <td style="font-size: 10px; border: 1px solid black; padding: 5px; height: 30px; vertical-align: middle; text-align: left;">
                    {{ $major->id }}
                </td>
                <td style="font-size: 10px; border: 1px solid black; padding: 5px; height: 30px; vertical-align: middle; text-align: left;">
                    {{ ucfirst($major->name) }}
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="2" style="font-size: 10px; border: 1px solid black; padding: 5px; height: 30px; vertical-align: middle; text-align: left; color: #666;">
                    No Program Majors
                </td>
            </tr>
        @endforelse
    @endforeach
    </tbody>
</table>
</body>
</html>
