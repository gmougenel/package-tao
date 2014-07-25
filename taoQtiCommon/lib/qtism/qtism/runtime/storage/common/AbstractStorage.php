<?php
/**
 * This program is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License
 * as published by the Free Software Foundation; under version 2
 * of the License (non-upgradable).
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
 *
 * Copyright (c) 2013-2014 (original work) Open Assessment Technologies SA (under the project TAO-PRODUCT);
 *
 * @author Jérôme Bogaerts, <jerome@taotesting.com>
 * @license GPLv2
 * @package qtism
 *  
 *
 */
namespace qtism\runtime\storage\common;

use qtism\runtime\tests\AbstractSessionManager;
use qtism\runtime\tests\AssessmentTestSession;
use qtism\data\AssessmentTest;
use \LogicException;

/**
 * The AbstractStorage class is extended by any class that claims to 
 * offer an AssessmentTestSession Storage Service. It will provide all the
 * functionalities to make AssessmentTestSession objects persistant and 
 * retrievable at will.
 * 
 * An AssessmentTestSession Storage Service must be able to:
 * 
 * * Instantiate a new AssessmentTestSession object from an AssessmentTest definition.
 * * Persist an AssessmentTestSession object for a later retrieval.
 * * Retrieve an AssessmentTestSession from an AssessmentTest definition and its session ID.
 * 
 * @author Jérôme Bogaerts <jerome@taotesting.com>
 *
 */
abstract class AbstractStorage {
    
    /**
     * The manager to be used to instantiate AssessmentTestSession and AssessmentItemSession objects.
     * 
     * @var AbstractSessionManager
     */
    private $manager;
    
    /**
     * Create a new AbstracStorage object.
     * 
     * @param AbstractSessionManager $manager The manager to be used to instantiate AssessmentTestSession and AssessmentItemSession objects.
     */
    public function __construct(AbstractSessionManager $manager) {
        $this->setManager($manager);
    }
    
    /**
     * Set the manager to be used to instantiate AssessmentTestSession and AssessmentItemSession objects.
     * 
     * @param AbstractSessionManager
     */
    protected function setManager(AbstractSessionManager $manager) {
        $this->manager = $manager;
    }
    
    /**
     * Get the manager to be used to instantiate AssessmentTestSession and AssessmentItemSession objects.
     *
     * @return AbstractSessionManager
     */
    protected function getManager() {
        return $this->manager;
    }
    
    /**
     * Instantiate an AssessmentTestSession from a given $assessmentTest AssessmentTest
     * definition. An AssessmentTestSession object is returned, with a session ID that will
     * make client code able to retrive persisted AssessmentTestSession objects later on.
     * 
     * If $sessionId is not provided, the AssessmentTestSession Storage Service implementation
     * must generate its own session ID. The ID generation algorithm is free, depending
     * on implementation needs.
     * 
     * @param AssessmentTest $test The test definition to be instantiated.
     * @param string $sessionId (optional) A $sessionId to be used to identify the instantiated AssessmentTest. If not given, an ID will be generated by the storage implementation.
     * @throws StorageException If an error occurs while instantiating the AssessmentTest definition into an AssessmentTestSession object.
     */
    abstract public function instantiate(AssessmentTest $assessmentTest, $sessionId = '');
    
    /**
     * Persist an AssessmentTestSession object for a later retrieval.
     * 
     * @param AssessmentTestSession $assessmentTestSession An AssessmentTestSession object to be persisted.
     * @throws StorageException If an error occurs while persisting the $assessmentTestSession object.
     */
    abstract public function persist(AssessmentTestSession $assessmentTestSession);
    
    /**
     * Retrieve a previously persisted AssessmentTestSession object by identifier.
     * 
     * @param AssessmentTest $test The test definition related to the AssessmentTestSession object to be retrieved.
     * @param string $sessionId The Session ID of the AssessmentTestSession object to be retrieved.
     * @throws StorageException If an error occurs while retrieving the AssessmentTestSession object.
     */
    abstract public function retrieve(AssessmentTest $assessmentTest, $sessionId);
}