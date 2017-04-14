<?php

/**
 * @file
 * Behat views context.
 */

use Behat\Behat\Context\SnippetAcceptingContext;
use Behat\Behat\Hook\Scope\BeforeScenarioScope;
use Drupal\DrupalExtension\Context\RawDrupalContext;

/**
 * Defines application features from the specific context.
 */
class ListjsThemeContext extends RawDrupalContext implements SnippetAcceptingContext {

  /**
   * Mink context.
   *
   * @var \Drupal\DrupalExtension\Context\MinkContext
   */
  protected $minkContext;

  /**
   * Initializes contexts before running every scenario.
   *
   * @BeforeScenario
   */
  public function gatherContexts(BeforeScenarioScope $scope) {
    $this->minkContext = $scope->getEnvironment()->getContext('Drupal\DrupalExtension\Context\MinkContext');
  }

  /**
   * Asserts whether field with value is found in region.
   *
   * @param string $value
   *   Value of the item.
   * @param string $field
   *   Field name.
   *   Example: "cat" or "house".
   * @param string $region
   *   Behat region.
   *
   * @Then I should see item with value :value as :field in :region
   */
  public function assertRowValueVisibility($value, $field, $region) {
    $text = $this->minkContext->getRegion($region)->find('css', "li .value_name-$field")->getText();
    PHPUnit_Framework_Assert::assertEquals($value, $text);
  }

  /**
   * Asserts whether field with value is not found in region.
   *
   * @param string $value
   *   Value of the item.
   * @param string $field
   *   Field name.
   *   Example: "cat" or "house".
   * @param string $region
   *   Behat region.
   *
   * @Then I should not see item with value :value as :field in :region
   */
  public function assertNoRowValueVisibility($value, $field, $region) {
    $text = $this->minkContext->getRegion($region)->find('css', "li .value_name-$field")->getText();
    PHPUnit_Framework_Assert::assertNotEquals($value, $text);
  }

  /**
   * Asserts whether item with value is placed in position in the region.
   *
   * @param string $value
   *   Item value.
   * @param string $field
   *   Field name.
   *   Example: "cat" or "house".
   * @param int $position
   *   Position of the item in list.
   * @param string $region
   *   Behat region.
   *
   * @Then I should see :value as :field at :position position in :region
   */
  public function assertRowPosition($value, $field, $position, $region) {
    $elements = $this->minkContext->getRegion($region)->findAll('css', "li .value_name-$field");
    PHPUnit_Framework_Assert::assertEquals($value, $elements[$position - 1]->getText());
  }

}
