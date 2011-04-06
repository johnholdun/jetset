<?php

require 'jetset.php';
require 'sfYaml/sfYaml.php';

$locations = parse_locations(sfYaml::Load('itinerary.yml'));

require 'template.phtml';