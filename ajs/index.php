

<!doctype html>
<html lang="en" ng-app="phonecatApp">
<head>
  <meta charset="utf-8">
  <title>My HTML File</title>
  <link rel="stylesheet" href="css/app.css">
  <link rel="stylesheet" href="css/bootstrap.css">
  <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.2.11/angular.min.js" type="application/javascript"></script>
  <script src="js/controllers.js"></script>
</head>
<body ng-controller="PhoneListCtrl"><div class="container-fluid">
  <div class="row-fluid">
    <div class="span2">
      <!--Sidebar content-->

      Search: <input ng-model="query">

    </div>
    <div class="span10">
      <!--Body content-->

      <ul class="phones" name="phonelist">
        <li ng-repeat="phone in filtered = (phones | filter:query)">
          {{phone.name}}
          <p>{{phone.snippet}}</p>
        </li>
      </ul>
      <p>{{filtered.length}} phone<span ng-if={{(filtered.length)-1}}>s</span> match<span ng-if={{(filtered.length)-1}}>es</span> your query.</p>

    </div>
  </div>
</div>

</body>
</html>