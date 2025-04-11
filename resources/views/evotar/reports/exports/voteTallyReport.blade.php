<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Vote Tally Report</title>
    <style>
        .council-header {
            background-color: #970707;
            color: white;
            font-weight: bold;
            font-size: 14px;
            padding: 10px;
            text-align: center;
        }
        th {
            background-color: #970707;
            color: white;
            font-weight: 700;
            font-size: 12px;
            border: 1px solid black;
            padding: 5px;
        }
        td {
            font-size: 10px;
            font-weight: bold;
            border: 1px solid black;
            padding: 5px;
        }
    </style>
</head>
<body>
<table style="width: 100%; border-collapse: collapse;">
    <tr>
        <th colspan="6" style="font-size: 14px; padding: 15px; height: 110px; text-align: center; vertical-align: middle; font-weight: 700; color: white;">

        </th>
    </tr>
    <tr>
        <td colspan="8" style="font-size: 10px; text-align: center; padding: 15px; height: 20px;  vertical-align: middle; font-weight: 300;" class="council-header">
            AS OF {{ now()->format('F j, Y - g:i A') }}
        </td>
    </tr>
    @foreach($groupedCandidates as $councilName => $candidates)
        <!-- Council Header -->
        <tr>
            <td colspan="8" style="font-size: 12px; padding: 15px; height: 20px;  vertical-align: middle; font-weight: 600;" class="council-header">
                {{ strtoupper($councilName) }}
            </td>
        </tr>

        <!-- Table Headers -->
        <tr>
            <th style="font-size: 12px; border: 1px solid black; padding: 5px; height: 30px; width: 120px; vertical-align: middle; text-align: left; background-color: #970707; font-weight:700; color: white">Candidate ID</th>
            <th style="font-size: 12px; border: 1px solid black; padding: 5px; height: 30px; width: 120px; vertical-align: middle; text-align: left; background-color: #970707; font-weight:700; color: white">First Name</th>
            <th style="font-size: 12px; border: 1px solid black; padding: 5px; height: 30px; width: 120px; vertical-align: middle; text-align: left; background-color: #970707; font-weight:700; color: white">Middle Initial</th>
            <th style="font-size: 12px; border: 1px solid black; padding: 5px; height: 30px; width: 120px; vertical-align: middle; text-align: left; background-color: #970707; font-weight:700; color: white">Last Name</th>
            <th style="font-size: 12px; border: 1px solid black; padding: 5px; height: 30px; width: 120px; vertical-align: middle; text-align: left; background-color: #970707; font-weight:700; color: white">Extension</th>
            <th style="font-size: 12px; border: 1px solid black; padding: 5px; height: 30px; width: 150px; vertical-align: middle; text-align: left; background-color: #970707; font-weight:700; color: white">Position</th>
            <th style="font-size: 12px; border: 1px solid black; padding: 5px; height: 30px; width: 150px; vertical-align: middle; text-align: left; background-color: #970707; font-weight:700; color: white">Party List</th>
            <th style="font-size: 12px; border: 1px solid black; padding: 5px; height: 30px; width: 150px; vertical-align: middle; text-align: left; background-color: #970707; font-weight:700; color: white">Votes</th>
        </tr>

        <!-- Candidates -->
        @foreach($candidates as $candidate)
            <tr>
                <td style="font-size: 10px; font-weight: bold; border: 1px solid black; text-align: left; height: 30px; vertical-align: middle; color: #000000">{{ $candidate->id }}</td>
                <td style="font-size: 10px; font-weight: bold; border: 1px solid black; text-align: left; height: 30px; vertical-align: middle; color: #000000">{{ $candidate->users->first_name ?? 'N/A' }}</td>
                <td style="font-size: 10px; font-weight: bold; border: 1px solid black; text-align: left; height: 30px; vertical-align: middle; color: #000000">{{ $candidate->users->middle_initial ?? 'n/a' }}</td>
                <td style="font-size: 10px; font-weight: bold; border: 1px solid black; text-align: left; height: 30px; vertical-align: middle; color: #000000">{{ $candidate->users->last_name ?? 'N/A' }}</td>
                <td style="font-size: 10px; font-weight: bold; border: 1px solid black; text-align: left; height: 30px; vertical-align: middle; color: #000000">{{ $candidate->users->extension ?? 'n/a' }}</td>
                <td style="font-size: 10px; font-weight: bold; border: 1px solid black; text-align: left; height: 30px; vertical-align: middle; color: #000000">{{ $candidate->election_positions->position->name ?? 'N/A' }}</td>
                <td style="font-size: 10px; font-weight: bold; border: 1px solid black; text-align: left; height: 30px; vertical-align: middle; color: #000000">{{ $candidate->partyLists->name ?? 'Independent' }}</td>
                <td style="font-size: 10px; font-weight: bold; border: 1px solid black; text-align: left; height: 30px; vertical-align: middle; color: #000000">{{ $candidate->votes_count }}</td>
            </tr>
        @endforeach

        <!-- Space between councils -->
        <tr><td colspan="8" style="height: 15px;"></td></tr>
    @endforeach
</table>
</body>
</html>
