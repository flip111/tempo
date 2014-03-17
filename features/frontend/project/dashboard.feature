@dashboard
Feature: dashboard project

  Background:
    Given I am connected as "admin"

  Scenario: Viewing the dashboard project
    When I am on route "project_home"

    And I should see "Select the organization"
    And I should see "Ikimea"
    And I should see "Apple"
    And I should see "Microsoft"
    And I should see "Pinterest"