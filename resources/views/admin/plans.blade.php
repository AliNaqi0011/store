<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link href="https://fonts.googleapis.com/css?family=Karla:400,700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.materialdesignicons.com/4.8.95/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{asset('css/pricing-plan.css')}}">
</head>

<body>
<main>
    <div class="container">
        <h5 class="text-center pricing-table-subtitle">PRICING PLAN</h5>
        <h1 class="text-center pricing-table-title">Pricing Table</h1>
        <div class="row">
            @foreach($plans as $plan)
            <div class="col-md-4">
                <div class="card pricing-card pricing-plan-basic">
                    <div class="card-body">
                        <p class="pricing-plan-title">{{ $plan->name }}</p>
                        <h3 class="pricing-plan-cost ml-auto">${{ $plan->price }}</h3>
                        <ul class="pricing-plan-features">
                            <li>Unlimited conferences</li>
                            <li>100 participants max</li>
                            <li>Custom Hold Music</li>
                            <li>10 participants max</li>
                        </ul>
                        <a href="{{ route('plans.show', $plan->slug) }}" class="btn pricing-plan-purchase-btn">Buy Now</a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</main>
<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
</body>

</html>
