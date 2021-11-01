<?php


class FilterCountriesTest extends TestCase
{
    /**
     * Test List Status.
     *
     * @return void
     */
    public function testListStatusCode()
    {
        $this->get('/filter');

        $this->assertResponseStatus(200);
    }

    /**
     * Test List Response.
     *
     * @return void
     */
    public function testListResponseStructure()
    {
        $response = $this->json("GET", '/filter', [], ['Accept' => 'application/json']);

        $this->assertResponseStatus(200);
        $response->seeJsonStructure(
            [
                "data" => [
                    "*" => [
                        "id",
                        "name",
                        "phone",
                        "state",
                        "code",
                        "country",
                    ]
                ],
                "links" => [
                    "first",
                    "last",
                    "prev",
                    "next"
                ],
                "meta"  =>  [
                    "current_page",
                    "from",
                    "last_page",
                    "links" =>  [
                        "*" =>  [
                            "url",
                            "label",
                            "active"
                        ]
                    ],
                    "path",
                    "per_page",
                    "to",
                    "total"
                ]
            ]
        );

        $response->seeJsonContains([
            "id" => 0,
            "name" => "Walid Hammadi",
            "phone" => "(212) 6007989253",
            "state" => "NOK",
            "code" => "(212)",
            "country" => "MOROCCO",
        ]);
    }

    public function testListWithCountryFilter()
    {
        $response = $this->json("GET", '/filter?country=Mozambique', [], ['Accept' => 'application/json']);
        $response->assertResponseStatus(200);
        $response->seeJsonContains([
            "id" => 7,
            "name" => "Edunildo Gomes Alberto ",
            "phone" => "(258) 847651504",
            "state" => "OK",
            "code" => "(258)",
            "country" => "MOZAMBIQUE"
        ]);
    }

    public function testListWithStateValidFilter()
    {
        $response = $this->json("GET", '/filter?state=valid', [], ['Accept' => 'application/json']);
        $response->assertResponseStatus(200);
        $response->seeJsonContains([
            "id" => 1,
            "name" => "Yosaf Karrouch",
            "phone" => "(212) 698054317",
            "state" => "OK",
            "code" => "(212)",
            "country" => "MOROCCO"
        ]);
    }

    public function testListWithStateInValidFilter()
    {
        $response = $this->json("GET", '/filter?state=invalid', [], ['Accept' => 'application/json']);
        $response->assertResponseStatus(200);
        $response->seeJsonContains([
            "id" => 0,
            "name" => "Walid Hammadi",
            "phone" => "(212) 6007989253",
            "state" => "NOK",
            "code" => "(212)",
            "country" => "MOROCCO"
        ]);
    }
}
