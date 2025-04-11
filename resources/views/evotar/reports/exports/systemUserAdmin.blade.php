<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Candidate Records</title>
</head>
<body>

<table style="width: 100%; border-collapse: collapse;">
    <thead>
    <tr>
        <th colspan="6" style="font-size: 14px; padding: 15px; height: 110px; text-align: center; vertical-align: middle; font-weight: 700; color: white;">

        </th>
    </tr>
    <tr>
        <th style="font-size: 12px; border: 1px solid black; padding: 5px; height: 30px; vertical-align: middle; text-align: left; background-color: #970707; font-weight:700; color: white">User ID</th>
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
        <th style="font-size: 12px; border: 1px solid black; padding: 5px; height: 30px; vertical-align: middle; text-align: left; background-color: #970707; font-weight:700; color: white">Account Type</th>
        <th></th>
    </tr>
    </thead>
    <tbody>
    @foreach($admins as $admin)
        <tr>
            <td style="font-size: 10px; font-weight: bold; border: 1px solid black; text-align: left; height: 30px; vertical-align: middle; color: #000000">
                {{ ucfirst($admin->id) }}
            </td>
            <td style="font-size: 10px; font-weight: bold; border: 1px solid black; text-align: left; height: 30px; vertical-align: middle;">
                {{ ucfirst($admin->first_name) }}
            </td>
            <td style="font-size: 10px; font-weight: bold; border: 1px solid black; text-align: left; height: 30px; vertical-align: middle; color: #000000">
                {{ ucfirst($admin->middle_initial) }}
            </td>
            <td style="font-size: 10px; font-weight: bold; border: 1px solid black; text-align: left; height: 30px; vertical-align: middle;">
                {{ ucfirst($admin->last_name) }}
            </td>
            <td style="font-size: 10px; font-weight: bold; border: 1px solid black; text-align: left; height: 30px; vertical-align: middle; color: #000000">
                {{ ucfirst($admin->extension) ?? 'n/a' }}
            </td>
            <td style="font-size: 10px; font-weight: bold; border: 1px solid black; text-align: left; height: 30px; vertical-align: middle;">
                {{ ucfirst($admin->gender) }}
            </td>
            <td style="font-size: 10px; font-weight: bold; border: 1px solid black; text-align: left; height: 30px; vertical-align: middle;">
                {{ ucfirst($admin->birth_date) }}
            </td>
            <td style="font-size: 10px; font-weight: bold; border: 1px solid black; text-align: left; height: 30px; vertical-align: middle; color: #000000">
                {{ ucfirst($admin->email) }}
            </td>
            <td style="font-size: 10px; font-weight: bold; border: 1px solid black; text-align: left; height: 30px; vertical-align: middle;">
                {{ ucfirst($admin->phone_number) }}
            </td>
            <td style="font-size: 10px; font-weight: bold; border: 1px solid black; text-align: left; height: 30px; vertical-align: middle; color: #000000">
                {{ ucfirst($admin->year_level) }}
            </td>
            <td style="font-size: 10px; font-weight: bold; border: 1px solid black; text-align: left; height: 30px; vertical-align: middle;">
                {{ ucfirst($admin->student_id) }}
            </td>
            <td style="font-size: 10px; font-weight: bold; border: 1px solid black; text-align: left; height: 30px; vertical-align: middle; color: #000000">
                {{ ucfirst($admin->campus->name) }}
            </td>
            <td style="font-size: 10px; font-weight: bold; border: 1px solid black; text-align: left; height: 30px; vertical-align: middle;">
                {{ ucfirst($admin->college->name) }}
            </td>
            <td style="font-size: 10px; font-weight: bold; border: 1px solid black; text-align: left; height: 30px; vertical-align: middle; color: #000000">
                {{ ucfirst($admin->program->name) }}
            </td>
            <td style="font-size: 10px; font-weight: bold; border: 1px solid black; text-align: left; height: 30px; vertical-align: middle;">
                {{ ucfirst($admin->programMajor->name) ?? 'n/a' }}
            </td>
            <td style="font-size: 10px; font-weight: bold; border: 1px solid black; text-align: left; height: 30px; vertical-align: middle; color: #000000">
                {{ $admin->roles->isNotEmpty() ? ucfirst($admin->roles->first()->name) : 'No Role' }}
            </td>

        </tr>
    @endforeach
    </tbody>
</table>
</body>
</html>
