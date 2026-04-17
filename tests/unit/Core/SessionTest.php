<?php

namespace Tests\Unit\Core;

use PHPUnit\Framework\TestCase;
use App\Core\Session;

class SessionTest extends TestCase
{
    private Session $session;

    protected function setUp(): void
    {
        parent::setUp();
        if (session_status() === PHP_SESSION_ACTIVE) {
            session_destroy();
        }
        $_SESSION = [];
        $this->session = new Session();
    }

    protected function tearDown(): void
    {
        $_SESSION = [];
        parent::tearDown();
    }

    public function testSetAndGetValue(): void
    {
        $this->session->set('test_key', 'test_value');
        
        $result = $this->session->get('test_key');
        
        $this->assertEquals('test_value', $result);
    }

    public function testGetReturnsDefaultForMissingKey(): void
    {
        $result = $this->session->get('nonexistent', 'default_value');
        
        $this->assertEquals('default_value', $result);
    }

    public function testHasReturnsTrueForExistingKey(): void
    {
        $this->session->set('test_key', 'value');
        
        $result = $this->session->has('test_key');
        
        $this->assertTrue($result);
    }

    public function testHasReturnsFalseForMissingKey(): void
    {
        $result = $this->session->has('nonexistent');
        
        $this->assertFalse($result);
    }

    public function testRemoveDeletesKey(): void
    {
        $this->session->set('test_key', 'value');
        $this->session->remove('test_key');
        
        $result = $this->session->has('test_key');
        
        $this->assertFalse($result);
    }

    public function testFlashSetsStatusMessage(): void
    {
        $this->session->flash('Success message');
        
        $this->assertTrue($this->session->has('status'));
    }

    public function testGetFlashReturnsAndClearsMessage(): void
    {
        $this->session->flash('Success message');
        $result = $this->session->getFlash();
        
        $this->assertEquals('Success message', $result);
        $this->assertFalse($this->session->has('status'));
    }

    public function testGetFlashReturnsNullWhenNoMessage(): void
    {
        $result = $this->session->getFlash();
        
        $this->assertNull($result);
    }

    public function testIsAuthReturnsFalseWhenNotAuthenticated(): void
    {
        $result = $this->session->isAuth();
        
        $this->assertFalse($result);
    }

    public function testIsAuthReturnsTrueWhenAuthenticated(): void
    {
        $_SESSION['auth'] = true;
        
        $result = $this->session->isAuth();
        
        $this->assertTrue($result);
    }

    public function testIsAuthReturnsFalseWhenAuthNotTrue(): void
    {
        $_SESSION['auth'] = 'not_true';
        
        $result = $this->session->isAuth();
        
        $this->assertFalse($result);
    }

    public function testRoleReturnsNullWhenNotSet(): void
    {
        $result = $this->session->role();
        
        $this->assertNull($result);
    }

    public function testRoleReturnsCorrectRole(): void
    {
        $_SESSION['loggedInUserRole'] = 'admin';
        
        $result = $this->session->role();
        
        $this->assertEquals('admin', $result);
    }

    public function testUserReturnsNullWhenNotSet(): void
    {
        $result = $this->session->user();
        
        $this->assertNull($result);
    }

    public function testUserReturnsCorrectUser(): void
    {
        $userData = ['user_id' => 1, 'name' => 'Test User'];
        $_SESSION['loggedInUser'] = $userData;
        
        $result = $this->session->user();
        
        $this->assertEquals($userData, $result);
    }

    public function testPharmacyIdReturnsNullWhenNotSet(): void
    {
        $result = $this->session->pharmacyId();
        
        $this->assertNull($result);
    }

    public function testPharmacyIdReturnsCorrectId(): void
    {
        $_SESSION['pharmacy_id'] = 5;
        
        $result = $this->session->pharmacyId();
        
        $this->assertEquals(5, $result);
    }

    public function testPharmacyIdCastsToInt(): void
    {
        $_SESSION['pharmacy_id'] = '10';
        
        $result = $this->session->pharmacyId();
        
        $this->assertIsInt($result);
        $this->assertEquals(10, $result);
    }

    public function testSetAuthForUserRole(): void
    {
        $user = ['user_id' => 1, 'name' => 'Test', 'email' => 'test@example.com'];
        $this->session->setAuth($user, 'user');
        
        $this->assertTrue($_SESSION['auth']);
        $this->assertEquals('user', $_SESSION['loggedInUserRole']);
        $this->assertEquals($user, $_SESSION['loggedInUser']);
        $this->assertEquals(1, $_SESSION['pharmacy_id']);
    }

    public function testSetAuthForAdminRole(): void
    {
        $user = ['user_id' => 1, 'name' => 'Admin', 'email' => 'admin@example.com'];
        $this->session->setAuth($user, 'admin');
        
        $this->assertTrue($_SESSION['auth']);
        $this->assertEquals('admin', $_SESSION['loggedInUserRole']);
        $this->assertEquals($user, $_SESSION['loggedInUser']);
        $this->assertArrayNotHasKey('pharmacy_id', $_SESSION);
    }

    public function testDestroyRemovesAllSessionData(): void
    {
        $_SESSION['auth'] = true;
        $_SESSION['loggedInUserRole'] = 'admin';
        $_SESSION['loggedInUser'] = ['user_id' => 1];
        $_SESSION['pharmacy_id'] = 1;
        
        $this->session->destroy();
        
        $this->assertFalse($_SESSION['auth']);
        $this->assertFalse(isset($_SESSION['loggedInUserRole']));
        $this->assertFalse(isset($_SESSION['loggedInUser']));
        $this->assertFalse(isset($_SESSION['pharmacy_id']));
    }

    public function testSetStoresArrayValue(): void
    {
        $data = ['key1' => 'value1', 'key2' => 'value2'];
        $this->session->set('array_key', $data);
        
        $result = $this->session->get('array_key');
        
        $this->assertEquals($data, $result);
    }

    public function testSetStoresIntegerValue(): void
    {
        $this->session->set('int_key', 42);
        
        $result = $this->session->get('int_key');
        
        $this->assertEquals(42, $result);
    }

    public function testSetStoresBooleanValue(): void
    {
        $this->session->set('bool_key', true);
        
        $result = $this->session->get('bool_key');
        
        $this->assertTrue($result);
    }
}