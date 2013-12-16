@account
Feature: User account profile edition
  Background:
    Given I am connected as "john.doe"

  Scenario: Viewing my personal information page
    Given I am on route "user_profile_edit"
    When I should see "Edit profile"