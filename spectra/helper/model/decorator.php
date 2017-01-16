<?php

  // IDEA: We might capture non-existant methods using __call() and  based on a limited subset of
  //       SQL interface we could auto-invoke the appropriate SQL gateway

  // Example:
  //   $model = new Decorator(Model());
  //   $model->selectWorkorderWhereNumberGt($number)
  //
  //   Would produce
  //
  //   $gateway->erp->getGateway()->select($table,