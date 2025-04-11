<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Voter List Records</title>
</head>
<body>

<table style="width: 100%; border-collapse: collapse;">
    <thead>
    <tr>
        <th colspan="6" style="font-size: 14px; padding: 15px; height: 110px; text-align: center; vertical-align: middle; font-weight: 700; color: white;">

        </th>
    </tr>
    <tr>
        <th style="font-size: 12px; border: 1px solid black; padding: 5px; height: 30px; vertical-align: middle; text-align: left; background-color: #970707; font-weight:700; color: white">Voter ID</th>
        <th style="font-size: 12px; border: 1px solid black; padding: 5px; height: 30px; vertical-align: middle; text-align: left; background-color: #970707; font-weight:700; color: white">First Name</th>
        <th style="font-size: 12px; border: 1px solid black; padding: 5px; height: 30px; vertical-align: middle; text-align: left; background-color: #970707; font-weight:700; color: white">Middle Initial</th>
        <th style="font-size: 12px; border: 1px solid black; padding: 5px; height: 30px; vertical-align: middle; text-align: left; background-color: #970707; font-weight:700; color: white">Last Name</th>
        <th style="font-size: 12px; border: 1px solid black; padding: 5px; height: 30px; vertical-align: middle; text-align: left; background-color: #970707; font-weight:700; color: white">Extension</th>
        <th style="font-size: 12px; border: 1px solid black; padding: 5px; height: 30px; vertical-align: middle; text-align: left; background-color: #970707; font-weight:700; color: white">Gender</th>
        <th style="font-size: 12px; border: 1px solid black; padding: 5px; height: 30px; vertical-align: middle; text-align: left; background-color: #970707; font-weight:700; color: white">Birthdate</th>
        <th style="font-size: 12px; border: 1px solid black; padding: 5px; height: 30px; vertical-align: middle; text-align: left; background-color: #970707; font-weight:700; color: white">Email</th>
        <th style="font-size: 12px; border: 1px solid black; padding: 5px; height: 30px; vertical-align: middle; text-align: left; background-color: #970707; font-weight:700; color: white">Phone Number</th>
        <th style="font-size: 12px; border: 1px solid black; padding: 5px; height: 30px; vertical-align: middle; text-align: left; background-color: #970707; font-weight:700; color: white">Year Level</th>
        <th style="font-size: 12px; border: 1px solid black; padding: 5px; height: 30px; vertical-align: middle; text-align: left; background-color: #970707; font-weight:700; color: white">Student ID</th>
        <th style="font-size: 12px; border: 1px solid black; padding: 5px; height: 30px; vertical-align: middle; text-align: left; background-color: #970707; font-weight:700; color: white">Campus</th>
        <th style="font-size: 12px; border: 1px solid black; padding: 5px; height: 30px; vertical-align: middle; text-align: left; background-color: #970707; font-weight:700; color: white">College</th>
        <th style="font-size: 12px; border: 1px solid black; padding: 5px; height: 30px; vertical-align: middle; text-align: left; background-color: #970707; font-weight:700; color: white">Program</th>
        <th style="font-size: 12px; border: 1px solid black; padding: 5px; height: 30px; vertical-align: middle; text-align: left; background-color: #970707; font-weight:700; color: white">Major</th>
        <th style="font-size: 12px; border: 1px solid black; padding: 5px; height: 30px; vertical-align: middle; text-align: left; background-color: #970707; font-weight:700; color: white">Account Status</th>

        <th></th>
    </tr>
    </thead>
    <tbody>
    @foreach($voters as $voter)
        <tr>
            <td style="font-size: 10px; font-weight: bold; border: 1px solid black; text-align: left; height: 30px; vertical-align: middle; color: #000000">
                {{ ucfirst($voter->id) }}
            </td>
            <td style="font-size: 10px; font-weight: bold; border: 1px solid black; text-align: left; height: 30px; vertical-align: middle;">
                {{ ucfirst($voter->first_name) }}
            </td>
            <td style="font-size: 10px; font-weight: bold; border: 1px solid black; text-align: left; height: 30px; vertical-align: middle; color: #000000">
                {{ ucfirst($voter->middle_initial) }}
            </td>
            <td style="font-size: 10px; font-weight: bold; border: 1px solid black; text-align: left; height: 30px; vertical-align: middle;">
                {{ ucfirst($voter->last_name) }}
            </td>
            <td style="font-size: 10px; font-weight: bold; border: 1px solid black; text-align: left; height: 30px; vertical-align: middle; color: #000000">
                {{ ucfirst($voter->extension) ?? 'n/a' }}
            </td>
            <td style="font-size: 10px; font-weight: bold; border: 1px solid black; text-align: left; height: 30px; vertical-align: middle;">
                {{ ucfirst($voter->gender) }}
            </td>
            <td style="font-size: 10px; font-weight: bold; border: 1px solid black; text-align: left; height: 30px; vertical-align: middle;">
                {{ ucfirst($voter->birth_date) }}
            </td>
            <td style="font-size: 10px; font-weight: bold; border: 1px solid black; text-align: left; height: 30px; vertical-align: middle; color: #000000">
                {{ ucfirst($voter->email) }}
            </td>
            <td style="font-size: 10px; font-weight: bold; border: 1px solid black; text-align: left; height: 30px; vertical-align: middle;">
                {{ ucfirst($voter->phone_number) }}
            </td>
            <td style="font-size: 10px; font-weight: bold; border: 1px solid black; text-align: left; height: 30px; vertical-align: middle; color: #000000">
                {{ ucfirst($voter->year_level) }}
            </td>
            <td style="font-size: 10px; font-weight: bold; border: 1px solid black; text-align: left; height: 30px; vertical-align: middle;">
                {{ ucfirst($voter->student_id) }}
            </td>
            <td style="font-size: 10px; font-weight: bold; border: 1px solid black; text-align: left; height: 30px; vertical-align: middle; color: #000000">
                {{ ucfirst($voter->campus->name) }}
            </td>
            <td style="font-size: 10px; font-weight: bold; border: 1px solid black; text-align: left; height: 30px; vertical-align: middle;">
                {{ ucfirst($voter->college->name) }}
            </td>
            <td style="font-size: 10px; font-weight: bold; border: 1px solid black; text-align: left; height: 30px; vertical-align: middle; color: #000000">
                {{ ucfirst($voter->program->name) }}
            </td>
            <td style="font-size: 10px; font-weight: bold; border: 1px solid black; text-align: left; height: 30px; vertical-align: middle;">
                {{ ucfirst($voter->programMajor->name) ?? 'n/a' }}
            </td>
            <td style="font-size: 10px; font-weight: bold; border: 1px solid black; text-align: left; height: 30px; vertical-align: middle; color: #000000">
                {{ ucfirst($voter->account_status) }}
            </td>

        </tr>
    @endforeach
    </tbody>
</table>
</body>
</html>
