Feature: dashboard project

  Background:
    Given I am connected as "admin"

  Scenario: Viewing the dashboard project
    When I go to "project/"

    And I should see "Select an organization to view its projects"
    And I should see "Ikimea"
    And I should see "Apple"
    And I should see "Microsoft"
    And I should see "Pinterest"