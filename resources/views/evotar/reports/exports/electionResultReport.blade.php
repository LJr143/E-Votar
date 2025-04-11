<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Election Result Report</title>
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
        <td colspan="8" style="text-align: center; height: 80px;">
            <h2>ELECTION WINNERS REPORT</h2>
            <p class="text-[10px]">
                ELECTRONIC GENERATE ON {{ now()->format('F j, Y - g:i A') }}
            </p>
            <p>{{ $election->name }} - {{ $election->campus->name }}</p>
        </td>
    </tr>
    @if(count($studentCouncilWinners) > 0)
        <!-- Council Header -->
        <tr>
            <td colspan="8" style="font-size: 12px; padding: 15px; height: 20px;  vertical-align: middle; font-weight: 600;" class="council-header">
                TAGUM STUDENT COUNCIL WINNERS
            </td>
        </tr>

        <!-- Table Headers -->
        <tr>
            <th style="font-size: 12px; border: 1px solid black; padding: 5px; height: 30px; width: 120px; vertical-align: middle; text-align: left; background-color: #970707; font-weight:700; color: white">Position</th>
            <th style="font-size: 12px; border: 1px solid black; padding: 5px; height: 30px; width: 120px; vertical-align: middle; text-align: left; background-color: #970707; font-weight:700; color: white">Candidate ID</th>
            <th style="font-size: 12px; border: 1px solid black; padding: 5px; height: 30px; width: 120px; vertical-align: middle; text-align: left; background-color: #970707; font-weight:700; color: white">Name</th>
            <th style="font-size: 12px; border: 1px solid black; padding: 5px; height: 30px; width: 120px; vertical-align: middle; text-align: left; background-color: #970707; font-weight:700; color: white">Council</th>
            <th style="font-size: 12px; border: 1px solid black; padding: 5px; height: 30px; width: 120px; vertical-align: middle; text-align: left; background-color: #970707; font-weight:700; color: white">Major</th>
            <th style="font-size: 12px; border: 1px solid black; padding: 5px; height: 30px; width: 150px; vertical-align: middle; text-align: left; background-color: #970707; font-weight:700; color: white">Party List</th>
            <th style="font-size: 12px; border: 1px solid black; padding: 5px; height: 30px; width: 150px; vertical-align: middle; text-align: left; background-color: #970707; font-weight:700; color: white">Votes</th>
            <th style="font-size: 12px; border: 1px solid black; padding: 5px; height: 30px; width: 150px; vertical-align: middle; text-align: left; background-color: #970707; font-weight:700; color: white">Percentage</th>
        </tr>

        <!-- Candidates -->
        @foreach($studentCouncilWinners as $winner)
            <tr>
                <td style="font-size: 10px; font-weight: bold; border: 1px solid black; text-align: left; height: 30px; vertical-align: middle; color: #000000">{{ $winner['position'] }}</td>
                <td style="font-size: 10px; font-weight: bold; border: 1px solid black; text-align: left; height: 30px; vertical-align: middle; color: #000000">{{ $winner['candidate']->id }}</td>
                <td style="font-size: 10px; font-weight: bold; border: 1px solid black; text-align: left; height: 30px; vertical-align: middle; color: #000000">{{ $winner['candidate']->users->first_name }} {{ $winner['candidate']->users->last_name }}</td>
                <td style="font-size: 10px; font-weight: bold; border: 1px solid black; text-align: left; height: 30px; vertical-align: middle; color: #000000">{{ $winner['council'] }}</td>
                <td style="font-size: 10px; font-weight: bold; border: 1px solid black; text-align: left; height: 30px; vertical-align: middle; color: #000000">{{ $winner['candidate']->users->programMajor->name ?? 'n/a' }}</td>
                <td style="font-size: 10px; font-weight: bold; border: 1px solid black; text-align: left; height: 30px; vertical-align: middle; color: #000000">{{ $winner['candidate']->partyLists->name ?? 'Independent' }}</td>
                <td style="font-size: 10px; font-weight: bold; border: 1px solid black; text-align: left; height: 30px; vertical-align: middle; color: #000000">{{ $winner['candidate']->votes_count }}</td>
                <td style="font-size: 10px; font-weight: bold; border: 1px solid black; text-align: left; height: 30px; vertical-align: middle; color: #000000">{{ $totalVoterVoted ? number_format(($winner['candidate']->votes_count / $totalVoterVoted) * 100, 2) : 0 }}%</td>
            </tr>
        @endforeach

    @endif
    @foreach($localCouncilWinners as $councilName => $winners)
        <!-- Space between councils -->
        <tr>
            <td style="font-size: 10px; font-weight: bold; border: 1px solid black; text-align: left; height: 30px; vertical-align: middle; color: #000000" class="council-header">
                {{ strtoupper($councilName) }} WINNERS
            </td>
        </tr>

        <tr>
            <th style="font-size: 12px; border: 1px solid black; padding: 5px; height: 30px; width: 120px; vertical-align: middle; text-align: left; background-color: #970707; font-weight:700; color: white">Position</th>
            <th style="font-size: 12px; border: 1px solid black; padding: 5px; height: 30px; width: 120px; vertical-align: middle; text-align: left; background-color: #970707; font-weight:700; color: white">Candidate ID</th>
            <th style="font-size: 12px; border: 1px solid black; padding: 5px; height: 30px; width: 120px; vertical-align: middle; text-align: left; background-color: #970707; font-weight:700; color: white">Name</th>
            <th style="font-size: 12px; border: 1px solid black; padding: 5px; height: 30px; width: 120px; vertical-align: middle; text-align: left; background-color: #970707; font-weight:700; color: white">Major</th>
            <th style="font-size: 12px; border: 1px solid black; padding: 5px; height: 30px; width: 150px; vertical-align: middle; text-align: left; background-color: #970707; font-weight:700; color: white">Party List</th>
            <th style="font-size: 12px; border: 1px solid black; padding: 5px; height: 30px; width: 150px; vertical-align: middle; text-align: left; background-color: #970707; font-weight:700; color: white">Votes</th>
            <th style="font-size: 12px; border: 1px solid black; padding: 5px; height: 30px; width: 150px; vertical-align: middle; text-align: left; background-color: #970707; font-weight:700; color: white">Percentage</th>
        </tr>
        @foreach($winners as $winner)
            <tr>
                <td style="font-size: 10px; font-weight: bold; border: 1px solid black; text-align: left; height: 30px; vertical-align: middle; color: #000000">{{ $winner['position'] }}</td>
                <td style="font-size: 10px; font-weight: bold; border: 1px solid black; text-align: left; height: 30px; vertical-align: middle; color: #000000">{{ $winner['candidate']->id }}</td>
                <td style="font-size: 10px; font-weight: bold; border: 1px solid black; text-align: left; height: 30px; vertical-align: middle; color: #000000">{{ $winner['candidate']->users->first_name }} {{ $winner['candidate']->users->last_name }}</td>
                <td style="font-size: 10px; font-weight: bold; border: 1px solid black; text-align: left; height: 30px; vertical-align: middle; color: #000000">{{ $winner['major'] }}</td>
                <td style="font-size: 10px; font-weight: bold; border: 1px solid black; text-align: left; height: 30px; vertical-align: middle; color: #000000">{{ $winner['candidate']->partyLists->name ?? 'Independent' }}</td>
                <td style="font-size: 10px; font-weight: bold; border: 1px solid black; text-align: left; height: 30px; vertical-align: middle; color: #000000">{{ $winner['candidate']->votes_count }}</td>
                <td style="font-size: 10px; font-weight: bold; border: 1px solid black; text-align: left; height: 30px; vertical-align: middle; color: #000000">{{ $totalVoterVoted ? number_format(($winner['candidate']->votes_count / $totalVoterVoted) * 100, 2) : 0 }}%</td>
            </tr>
        @endforeach
    @endforeach
</table>
</body>
</html>
