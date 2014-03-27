@account
Feature: User account profile edition
  Background:
    Given I am connected as "john.doe"

  Scenario: Viewing my personal information page
    Given I am on route "user_profile_edit"
    When I should see "Edit profile"
        And I fill in "First name" with "Doe"
        And I fill in "Last name" with "John"
        And I fill in "Phone" with "0100000000"
        And I fill in "Mobile phone" with "0600000000"
        And I fill in "Company" with "Castor inc"
        And I fill in "Job title" with "amnesic"
        And I press "Save changes"
    Then I am on route "user_profile_edit"
    Then the "Company" field should contain "Castor inc"
    Then the "First name" field should contain "Doe"
    Then the "Last name" field should contain "John"
    Then the "Phone" field should contain "0100000000"
    Then the "Mobile phone" field should contain "0600000000"
    Then the "Company" field should contain "Castor inc"
    Then the "Job title" field should contain "amnesic"
