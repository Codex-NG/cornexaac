function getPlayerNameByGUID(guid)
     local resultx = db.storeQuery("SELECT `name` FROM `players` WHERE `id` = " .. guid)
     if resultx then
         name = result.getDataString(resultx, 'name')
         result.free(resultx)
         return name
     end
     return LUA_ERROR
end


function sendItem()
    local dbResults = db.storeQuery("SELECT * FROM `__cornexaac_shop_orders`")

    if dbResults ~= false then

        repeat
            local playerId = result.getDataInt(dbResults, 'player_id')
            
            player = Player(getPlayerNameByGUID(playerId))

            if player then 
                local itemid = result.getDataInt(dbResults, 'itemid')
                local count = result.getDataInt(dbResults, 'count')

                -- Make sure the player got enough of cap
                if player:getFreeCapacity() < ItemType(itemid):getWeight(count) then
                    player:sendTextMessage(MESSAGE_EVENT_ORANGE, 'You are waiting for a order from donate shop, but you don\'t have enough cap.')

                    addEvent(sendItem, 5000)
                    return false
                end

                -- Make sure the player got space in backpack
                local container = player:getSlotItem(3)
                if container:isContainer() then
                    if isItemStackable(itemid) and container:getEmptySlots() > 0 then 
                        player:addItem(itemid, count, false)

                        player:sendTextMessage(MESSAGE_EVENT_ORANGE, 'You have received '..count..'x '..getItemName(itemid)..'(s) from donate shop.')

                        db.query("DELETE FROM `__cornexaac_shop_orders` WHERE `id` = ".. result.getDataInt(dbResults, 'id') .." ")
                    elseif container:getEmptySlots() >= count then 
                        player:addItem(itemid, count, false)

                        player:sendTextMessage(MESSAGE_EVENT_ORANGE, 'You have received '..count..'x '..getItemName(itemid)..'(s) from donate shop.')

                        db.query("DELETE FROM `__cornexaac_shop_orders` WHERE `id` = ".. result.getDataInt(dbResults, 'id') .." ")
                    else
                        player:sendTextMessage(MESSAGE_EVENT_ORANGE, 'You are waiting for a order from donate shop, buy you don\'t have enough of free space in your backpack.')

                        addEvent(sendItem, 5000)
                        return false
                    end
                end

                db.query("DELETE FROM `__cornexaac_shop_orders` WHERE `id` = ".. result.getDataInt(dbResults, 'id') .." ")
            end
        until not result.next(dbResults)

        result.free(dbResults)
    end

    addEvent(sendItem, 5000)
end

sendItem()