Feature: dashboard project

  Background:
    Given I am connected as "admin"

  Scenario: Viewing the dashboard project
    When I am on "organization/ikimea/show"

    And I should see "0 Open"
    And I should see "1 close"
