Feature: dashboard project

  Background:
    Given I am connected as "admin"

  Scenario: Viewing the dashboard project
    When I am on "project/moeull-mipres/show"

    And I should see "0 Open"
    And I should see "1 close"
