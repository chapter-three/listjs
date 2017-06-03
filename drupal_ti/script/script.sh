#!/bin/bash

# Add an optional statement to see that this is running in Travis CI.
echo "running drupal_ti/script/script.sh"

set -e "$DRUPAL_TI_DEBUG"

DRUPAL_TI_ESLINT_PATH="$DRUPAL_TI_DRUPAL_DIR/.eslintrc"
DRUPAL_TI_LISTJS_JS_PATH="./js"

# Ensure the right Drupal version is installed.
# Note: This function is re-entrant.
drupal_ti_ensure_drupal

ls -al "$DRUPAL_TI_DRUPAL_DIR/modules/$DRUPAL_TI_MODULE_NAME/modules"
ls -al "$DRUPAL_TI_DRUPAL_DIR/modules/$DRUPAL_TI_MODULE_NAME/tests/modules"
ls -al "$DRUPAL_TI_DRUPAL_DIR/modules/$DRUPAL_TI_MODULE_NAME/tests/src/FunctionalJavascript"

# Check Drupal code standard.
eslint --config "$DRUPAL_TI_ESLINT_PATH $DRUPAL_TI_LISTJS_JS_PATH"
phpcs --standard=Drupal --extensions=php,module,inc,install,profile,theme,css,info,txt,md modules templates tests listjs.module
phpcs --standard=DrupalPractice --extensions=php,module,inc,install,profile,theme,css,info,txt,md modules templates tests listjs.module
