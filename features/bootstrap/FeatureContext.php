<?php

use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Gherkin\Node\TableNode;

/**
 * Defines application features from the specific context.
 */
class FeatureContext implements Context
{
    /**
     * Initializes context.
     *
     * Every scenario gets its own context instance.
     * You can also pass arbitrary arguments to the
     * context constructor through behat.yml.
     */
    public function __construct()
    {
        $this->bearerToken = "eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiIsImp0aSI6IjY1ZGUyMGI4N2ZlOTc3ZjBlNmVlMmEwMWVmYzliZDBiYWE1OTg5Njc5MWQxZDA1OWMzODRmZWFmMzhjMWM3YjllMTU2NmMxNTY0NTk1MTNjIn0.eyJhdWQiOiIzIiwianRpIjoiNjVkZTIwYjg3ZmU5NzdmMGU2ZWUyYTAxZWZjOWJkMGJhYTU5ODk2NzkxZDFkMDU5YzM4NGZlYWYzOGMxYzdiOWUxNTY2YzE1NjQ1OTUxM2MiLCJpYXQiOjE1OTQyMjE1NDMsIm5iZiI6MTU5NDIyMTU0MywiZXhwIjoxNjI1NzU3NTQxLCJzdWIiOiIyIiwic2NvcGVzIjpbXX0.dEPUurRB2Wz2jDhXolTLg9pfngkA4J_P9z3yvHNzrffW0KgIIk-vTJtgG7jII4nweanwaJU8VEn-D_-xYqYQx9wevcHPSrgoJtHfN4ehwQTfQbFPEE6-rCbvl8TerIRJQq0Jb_ylzI1aIrW7OcS8OUwekORMGVrtXNmCXa2VLpuk89CddscuLFNooDL6xe-sKNb2RcGNWoBoysklTgx00xP6GQ2OaLs4Cnf3wgu-xuxY5VAaiX_rbzjS5c_6Uq_sjonvFGPJ1I4b0etxyFe7SVQTPmQmeI25osRpZcznhzDiYy9RqEdguIhVlOceOL-Y9hef-aYvB67m2-ZHExwKfATKdkr5O2GRsyFqJrmOdfwMfFlUABFKy1l8rHTZM7p4YTmck7KHggxz0IQhK7W4RWGfv4greKXW6WYgc86PTcpGx86sip_GhOEEYD8Y3GWQgRp2orYpuPgstdJ3d9I4jFuQb-JVD9AySvQYwKvbpjG1BihHR9lfzKeJJZOLvETC09HOORly01OuDjJ1ndU-f4ZIy9DfOLwMMR9ebPxsnnPsaJX8TFSWOqWxGU07sprdeMrGUg9nmrcA2hW6lsVABbLqXnEh7p0OcwVGx7w_lFmvG1E7rEmgJnxb-dQ5-tPn8OxsxQNoXI8Jsj5Rd87i_eAPX2tlbmwD6p_oPa4eplM";
    }

    /**
     * @Given I have the payload:
     */
    public function iHaveThePayload(PyStringNode $string)
    {
        $this->payload = $string;
    }

    /**
     * @When /^I request "(GET|PUT|POST|DELETE|PATCH) ([^"]*)"$/
     */
    public function iRequest($httpMethod, $argument1)
    {
        $client = new GuzzleHttp\Client();
        $this->response = $client->request(
            $httpMethod,
            'http://127.0.0.1:8000' . $argument1,
            [
                'body' => $this->payload,
                'headers' => [
                    "Authorization" => "Bearer {$this->bearerToken}",
                    "Content-Type" => "application/json",
                ],
            ]
        );
        $this->responseBody = $this->response->getBody(true);
    }

    /**
     * @Then /^I get a response$/
     */
    public function iGetAResponse()
    {
        if (empty($this->responseBody)) {
            throw new Exception('Did not get a response from the API');
        }
    }

    /**
     * @Given /^the response is JSON$/
     */
    public function theResponseIsJson()
    {
        $data = json_decode($this->responseBody);

        if (empty($data)) {
            throw new Exception("Response was not JSON\n" . $this->responseBody);
        }
    }

     /**
     * @Then the response contains :arg1 records
     */
    public function theResponseContainsRecords($arg1)
    {
       $data=json_decode($this->responseBody);
       $count = count($data);
       return ($count == $arg1);
    }

     /**
     * @Then the question contains a title of :arg1
     */
    public function theQuestionContainsATitleOf($arg1)
    {

        $data=json_decode($this->responseBody);
        if($data->title == $arg1){
        }else {
            throw new Exception('The title dont match');

        }
    }
}
   