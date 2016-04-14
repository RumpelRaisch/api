<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <!--[if IE]><link rel="shortcut icon" href="http://php.bitshifting.de/favicon.ico"><![endif]-->
    <link rel="icon" href="http://php.bitshifting.de/favicon.ico">

    <title>FireFall - Ability Duration Timer - Ability Infos</title>

    <link href="http://php.bitshifting.de/api/firefall/css/bootstrap.darkly.min.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>

  <body>

    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <div class="well">
            <?php if (true === isset($aAbilities) AND true === is_array($aAbilities)): ?>
            <div class="alert alert-success">
              <p class="lead text-center"><?php print count($aAbilities); ?> abilities collected so far</p>
            </div>
            <?php endif; ?>
            <table class="table table-striped table-condensed table-hover">
              <thead>
                <tr class="info">
                  <th class="text-center">ID</th>
                  <th class="text-center">Icon</th>
                  <th class="text-center">Name</th>
                  <th class="text-center">Event</th>
                  <th class="text-center">Reports Duration</th>
                  <th class="text-center">Used by Addon</th>
                </tr>
              </thead>
              <tbody>
                <?php if (true === isset($aAbilities) AND true === is_array($aAbilities)): ?>
                <?php foreach ($aAbilities as $oAbility): ?>
                <?php if ($oAbility instanceof AdtAbilityInfosModel): ?>
                <tr>
                  <td class="text-right">
                    <?php print $oAbility->getAbilityId(); ?>
                  </td>
                  <td class="text-right">
                    <?php if (1 > $oAbility->getAbilityIconId()): ?>
                    <span class="glyphicon glyphicon-remove text-danger" aria-hidden="true"></span>
                    <?php else: ?>
                    <?php print $oAbility->getAbilityIconId(); ?>
                    <?php endif; ?>
                  </td>
                  <td class="text-left">
                    <?php print trim($oAbility->getAbilityName()); ?>
                  </td>
                  <td class="text-left">
                    <?php print $oAbility->getAbilityEvent(); ?>
                  </td>
                  <td class="text-center">
                    <?php if (1 == $oAbility->getAbilityReportsDuration()): ?>
                    <span class="glyphicon glyphicon-ok text-success" aria-hidden="true"></span>
                    <?php else: ?>
                    <span class="glyphicon glyphicon-remove text-danger" aria-hidden="true"></span>
                    <?php endif; ?>
                  </td>
                  <td class="text-center">
                    <?php if (1 == $oAbility->getAbilityUsedByAddon()): ?>
                    <span class="glyphicon glyphicon-ok text-success" aria-hidden="true"></span>
                    <?php else: ?>
                    <span class="glyphicon glyphicon-remove text-danger" aria-hidden="true"></span>
                    <?php endif; ?>
                  </td>
                </tr>
                <?php endif; ?>
                <?php endforeach; ?>
                <?php endif; ?>
              </tbody>
              <tfoot>
                <tr class="info">
                  <th class="text-center">ID</th>
                  <th class="text-center">Icon</th>
                  <th class="text-center">Name</th>
                  <th class="text-center">Event</th>
                  <th class="text-center">Reports Duration</th>
                  <th class="text-center">Used by Addon</th>
                </tr>
              </tfoot>
            </table>
          </div> <!-- /.well -->
        </div> <!-- /.col-md-12 -->
      </div> <!-- /.row -->
    </div> <!-- /.container -->

    <script src="http://php.bitshifting.de/api/firefall/js/bootstrap.min.js"></script>
  </body>
</html>
