<?php
/*
 * Copyright 2015-present MongoDB, Inc.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *   https://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

namespace MongoDB;

use MongoDB\Driver\Exception\LogicException;
use MongoDB\Driver\WriteResult;

/**
 * Result class for an update operation.
 */
class UpdateResult
{
    public function __construct(private WriteResult $writeResult)
    {
    }

    /**
     * Return the number of documents that were matched by the filter.
     *
     * This method should only be called if the write was acknowledged.
     *
     * @see UpdateResult::isAcknowledged()
     * @throws LogicException if the write result is unacknowledged
     */
    public function getMatchedCount(): int
    {
        return $this->writeResult->getMatchedCount();
    }

    /**
     * Return the number of documents that were modified.
     *
     * This value is undefined (i.e. null) if the write executed as a legacy
     * operation instead of command.
     *
     * This method should only be called if the write was acknowledged.
     *
     * @see UpdateResult::isAcknowledged()
     * @throws LogicException if the write result is unacknowledged
     */
    public function getModifiedCount(): int
    {
        return $this->writeResult->getModifiedCount();
    }

    /**
     * Return the number of documents that were upserted.
     *
     * This method should only be called if the write was acknowledged.
     *
     * @see UpdateResult::isAcknowledged()
     * @throws LogicException if the write result is unacknowledged
     */
    public function getUpsertedCount(): int
    {
        return $this->writeResult->getUpsertedCount();
    }

    /**
     * Return the ID of the document inserted by an upsert operation.
     *
     * If the document had an ID prior to upserting (i.e. the server did not
     * need to generate an ID), this will contain its "_id". Any
     * server-generated ID will be a MongoDB\BSON\ObjectId instance.
     *
     * This value is undefined (i.e. null) if an upsert did not take place.
     *
     * This method should only be called if the write was acknowledged.
     *
     * @see UpdateResult::isAcknowledged()
     * @throws LogicException if the write result is unacknowledged
     */
    public function getUpsertedId(): mixed
    {
        foreach ($this->writeResult->getUpsertedIds() as $id) {
            return $id;
        }

        return null;
    }

    /**
     * Return whether this update was acknowledged by the server.
     *
     * If the update was not acknowledged, other fields from the WriteResult
     * (e.g. matchedCount) will be undefined and their getter methods should not
     * be invoked.
     */
    public function isAcknowledged(): bool
    {
        return $this->writeResult->isAcknowledged();
    }
}
