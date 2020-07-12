Feature: Sample Tests
In order to test the API
I need to be able to test the API

Scenario: Get Questions
Given i have the payload:
"""
"""
When I request "GET /api/questions"
Then the response is JSON
Then the response contains 50 records

Scenario: Add Questions
Given i have the payload:
"""
{
    "title": "Behat",
    "question":"Is it awesome?",
    "poll_id":2
}
"""
When I request "POST /api/questions"
Then the response is JSON
Then the question contains a title of "Behat"
