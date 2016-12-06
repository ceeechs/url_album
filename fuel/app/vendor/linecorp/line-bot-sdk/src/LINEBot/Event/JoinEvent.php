<?php

/**
 * Copyright 2016 LINE Corporation
 *
 * LINE Corporation licenses this file to you under the Apache License,
 * version 2.0 (the "License"); you may not use this file except in compliance
 * with the License. You may obtain a copy of the License at:
 *
 *   https://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS, WITHOUT
 * WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied. See the
 * License for the specific language governing permissions and limitations
 * under the License.
 */

namespace LINE\LINEBot\Event;

use LINE\LINEBot\Constant\EventSourceType;
use LINE\LINEBot\Exception\InvalidEventSourceException;

/**
 * A class that represents the event of joining.
 *
 * @package LINE\LINEBot\Event
 */
class JoinEvent extends BaseEvent
{
    /**
     * JoinEvent constructor.
     *
     * @param array $event
     */
    public function __construct($event)
    {
        parent::__construct($event);
    }

    public function getEventSourceType()
    {
        if ($this->isUserEvent()) {
            return 1;
        }

        if ($this->isRoomEvent()) {
            return 2;
        }

        if ($this->isGroupEvent()) {
            return 3;
        }

        throw new InvalidEventSourceException('Invalid event source type, neither `user`, `room` nor `group`');
    }
}
