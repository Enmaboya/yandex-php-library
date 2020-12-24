<?php


/**
 * @namespace
 */

namespace Yandex\Tests\Passport;

use GuzzleHttp\Psr7\Response;
use Yandex\Passport\PassportClient;
use Yandex\Tests\TestCase;

/**
 *
 * Class PassportClientTest
 * @package Yandex\Tests\Market\Partner
 */
class PassportClientTest extends TestCase
{
    protected $fixturesFolder = 'fixtures';

    /**
     * @param $fixture
     * @return PassportClient
     */
    protected function getMock($fixture)
    {
        $response = new Response(200, [], \GuzzleHttp\Psr7\stream_for($fixture));

        $clientMock = $this->getMockBuilder(PassportClient::class)
                           ->setMethods(['sendRequest'])
                           ->getMock();
        $clientMock->expects($this->any())
                   ->method('sendRequest')
                   ->will($this->returnValue($response));
        return $clientMock;
    }

    function testBaseRequest()
    {
        $fixture     = file_get_contents(__DIR__ . '/' . $this->fixturesFolder . '/base.json');
        $fixtureJson = json_decode($fixture);

        $clientMock = $this->getMock($fixture);
        $passport   = $clientMock->getInfo('test-tocken');

        $this->assertEquals($fixtureJson->login, $passport->getLogin());
        $this->assertEquals($fixtureJson->id, $passport->getId());

        $this->assertEquals($fixtureJson->openid_identities, $passport->getOpenidIdentities()
                                                                      ->asArray());

        $this->assertEmpty($passport->getFirstName());
        $this->assertEmpty($passport->getLastName());
        $this->assertEmpty($passport->getDisplayName());
        $this->assertEmpty($passport->getDefaultEmail());
        $this->assertEmpty($passport->getRealName());
        $this->assertEmpty($passport->getisAvatarEmpty());
        $this->assertEmpty($passport->getBirthday());
        $this->assertEmpty($passport->getDefaultAvatarId());
        $this->assertEmpty($passport->getOldSocialLogin());
        $this->assertEmpty($passport->getSex());

    }

    function testFioSexRequest()
    {
        $fixture     = file_get_contents(__DIR__ . '/' . $this->fixturesFolder . '/fio-sex.json');
        $fixtureJson = json_decode($fixture);

        $clientMock = $this->getMock($fixture);
        $passport   = $clientMock->getInfo('test-tocken');

        $this->assertEquals($fixtureJson->login, $passport->getLogin());
        $this->assertEquals($fixtureJson->id, $passport->getId());
        $this->assertEquals($fixtureJson->first_name, $passport->getFirstName());
        $this->assertEquals($fixtureJson->last_name, $passport->getLastName());
        $this->assertEquals($fixtureJson->sex, $passport->getSex());
        $this->assertEquals($fixtureJson->display_name, $passport->getDisplayName());
        $this->assertEquals($fixtureJson->real_name, $passport->getRealName());
        $this->assertEquals($fixtureJson->old_social_login, $passport->getOldSocialLogin());

        $this->assertEquals($fixtureJson->openid_identities, $passport->getOpenidIdentities()
                                                                      ->asArray());

        $this->assertEmpty($passport->getDefaultEmail());
        $this->assertEmpty($passport->getisAvatarEmpty());
        $this->assertEmpty($passport->getBirthday());
        $this->assertEmpty($passport->getDefaultAvatarId());

    }

    function testEmailRequest()
    {
        $fixture     = file_get_contents(__DIR__ . '/' . $this->fixturesFolder . '/email.json');
        $fixtureJson = json_decode($fixture);

        $clientMock = $this->getMock($fixture);
        $passport   = $clientMock->getInfo('test-tocken');

        $this->assertEquals($fixtureJson->login, $passport->getLogin());
        $this->assertEquals($fixtureJson->id, $passport->getId());
        $this->assertEquals($fixtureJson->default_email, $passport->getDefaultEmail());
        $this->assertEquals($fixtureJson->old_social_login, $passport->getOldSocialLogin());

        $this->assertEquals($fixtureJson->openid_identities, $passport->getOpenidIdentities()
                                                                      ->asArray());
        $this->assertEquals($fixtureJson->emails, $passport->getEmails()
                                                           ->asArray());

        $this->assertEmpty($passport->getFirstName());
        $this->assertEmpty($passport->getLastName());
        $this->assertEmpty($passport->getDisplayName());
        $this->assertEmpty($passport->getRealName());
        $this->assertEmpty($passport->getisAvatarEmpty());
        $this->assertEmpty($passport->getBirthday());
        $this->assertEmpty($passport->getDefaultAvatarId());
        $this->assertEmpty($passport->getSex());

    }

    function testBirthdayRequest()
    {
        $fixture     = file_get_contents(__DIR__ . '/' . $this->fixturesFolder . '/birthday.json');
        $fixtureJson = json_decode($fixture);

        $clientMock = $this->getMock($fixture);
        $passport   = $clientMock->getInfo('test-tocken');

        $this->assertEquals($fixtureJson->login, $passport->getLogin());
        $this->assertEquals($fixtureJson->id, $passport->getId());
        $this->assertEquals($fixtureJson->birthday, $passport->getBirthday());
        $this->assertEquals($fixtureJson->old_social_login, $passport->getOldSocialLogin());

        $this->assertEquals($fixtureJson->openid_identities, $passport->getOpenidIdentities()
                                                                      ->asArray());


        $this->assertEmpty($passport->getFirstName());
        $this->assertEmpty($passport->getLastName());
        $this->assertEmpty($passport->getDisplayName());
        $this->assertEmpty($passport->getDefaultEmail());
        $this->assertEmpty($passport->getRealName());
        $this->assertEmpty($passport->getisAvatarEmpty());
        $this->assertEmpty($passport->getDefaultAvatarId());
        $this->assertEmpty($passport->getSex());

    }

    function testAvatarRequest()
    {
        $fixture     = file_get_contents(__DIR__ . '/' . $this->fixturesFolder . '/avatar.json');
        $fixtureJson = json_decode($fixture);

        $clientMock = $this->getMock($fixture);
        $passport   = $clientMock->getInfo('test-tocken');

        $this->assertEquals($fixtureJson->login, $passport->getLogin());
        $this->assertEquals($fixtureJson->id, $passport->getId());
        $this->assertEquals($fixtureJson->old_social_login, $passport->getOldSocialLogin());
        $this->assertEquals($fixtureJson->is_avatar_empty, $passport->getisAvatarEmpty());
        $this->assertEquals($fixtureJson->default_avatar_id, $passport->getDefaultAvatarId());
        $this->assertFalse($passport->getisAvatarEmpty());

        $this->assertEquals($fixtureJson->openid_identities, $passport->getOpenidIdentities()
                                                                      ->asArray());


        $this->assertEmpty($passport->getFirstName());
        $this->assertEmpty($passport->getLastName());
        $this->assertEmpty($passport->getDisplayName());
        $this->assertEmpty($passport->getDefaultEmail());
        $this->assertEmpty($passport->getRealName());
        $this->assertEmpty($passport->getBirthday());
        $this->assertEmpty($passport->getSex());

    }

    function testFullAccessRequest()
    {
        $fixture     = file_get_contents(__DIR__ . '/' . $this->fixturesFolder . '/full-access.json');
        $fixtureJson = json_decode($fixture);

        $clientMock = $this->getMock($fixture);
        $passport   = $clientMock->getInfo('test-tocken');

        $this->assertEquals($fixtureJson->first_name, $passport->getFirstName());
        $this->assertEquals($fixtureJson->last_name, $passport->getLastName());
        $this->assertEquals($fixtureJson->display_name, $passport->getDisplayName());
        $this->assertEquals($fixtureJson->default_email, $passport->getDefaultEmail());
        $this->assertEquals($fixtureJson->real_name, $passport->getRealName());
        $this->assertEquals($fixtureJson->is_avatar_empty, $passport->getisAvatarEmpty());
        $this->assertEquals($fixtureJson->birthday, $passport->getBirthday());
        $this->assertEquals($fixtureJson->default_avatar_id, $passport->getDefaultAvatarId());
        $this->assertEquals($fixtureJson->login, $passport->getLogin());
        $this->assertEquals($fixtureJson->old_social_login, $passport->getOldSocialLogin());
        $this->assertEquals($fixtureJson->sex, $passport->getSex());
        $this->assertEquals($fixtureJson->id, $passport->getId());
        $this->assertEquals($fixtureJson->openid_identities, $passport->getOpenidIdentities()
                                                                      ->asArray());
        $this->assertEquals($fixtureJson->emails, $passport->getEmails()
                                                           ->asArray());
    }

}