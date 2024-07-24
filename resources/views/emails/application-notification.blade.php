<!DOCTYPE html>
<html>

<head>
    <title>Welcome to EmailerApp</title>
</head>

<body>
    <h1>Hello from Department of Health - CHD XII!</h1>
    <p>Good day {{$name}} ({{$email}}),

    <p>We would like to inform you that your initial application for licensing of your water refilling facility/station
        is @if($application_status==="Accepted")
        {{strtolower($application_status)}}.
    <p>We hereby request that you prepare any and all important documents for inspection in your facility.
        The date of your inspection will be on {{$inspection_date}}.
    </p>
    @else
    <p>{{$application_status}} due to "{{$remarks}}".</p>
    <br />
    <p>We hereby request that you comply the missing documents/requirements in order for us to proceed with you
        application.</p>
    @endif</p>
    </p>

    <p>We hope you have a nice day ahead!</p>
    <p>Sincerely,</p>
    <p>Department of Health - Center for Health Development</p>
    <p>SOCCSKSARGEN Region</p>
</body>

</html>
