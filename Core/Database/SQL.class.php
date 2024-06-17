<?php

namespace Core\Database;

abstract class SQL {

    const GET_QUESTIONS = "SELECT * FROM questions WHERE category LIKE :category ORDER BY rand()";

    const INIT_SCOREBOARD = 
    "INSERT INTO 
        scoreboard(guestID, groupID, username, ip, startTime, maxScore, category)
    VALUES
        (:guestId, '#CURRENT', :nickname, :ip, :startTime, :maxScore, :category)";

    const UPDATE_SCOREBOARD = "UPDATE scoreboard SET score = :score , finishTime = :finishTime WHERE guestID = :guestId";

    const DELETE_GUEST = "DELETE FROM scoreboard WHERE guestID = :guestId";
    const DELETE_GROUP = "DELETE FROM scoreboard WHERE groupID = :groupId";
    const TOGGLE_DISQUALIFICATION = "UPDATE scoreboard SET isDisqualified = (isDisqualified + 1) % 2 WHERE guestID = :guestId";

    const GET_GUESTS = 
    "SELECT
        guestID,
        username,
        ip,
        startTime,
        finishTime,
        score,
        isDisqualified,
        !!finishTime AS isFinished,
        finishTime - (startTime * !!finishTime) AS attemptTime
    FROM 
        scoreboard
    WHERE 
        groupID = :groupId
    ORDER BY
        isDisqualified ASC,
        isFinished DESC,
        score DESC,
        attemptTime ASC,
        startTime ASC";

    const GET_RANKING = 
    "SELECT * FROM (
        SELECT
            row_number() OVER (ORDER BY
                isDisqualified ASC,
                isFinished DESC,
                score DESC,
                attemptTime ASC,
                startTime ASC
            ) AS placement,
            guestID,
            username,
            score,
            !!finishTime AS isFinished,
            finishTime - (startTime * !!finishTime) AS attemptTime
        FROM 
            scoreboard
        WHERE 
            groupID = '#CURRENT' AND isDisqualified = 0 AND finishTime != 0
    ) ranking
        WHERE placement <= 10 OR guestID = :guestId";
    
    const EXPIRE_CURRENT_GROUP = 
        "UPDATE 
            scoreboard
        SET 
            groupID = ( SELECT guestID FROM scoreboard WHERE groupID = '#CURRENT' LIMIT 1 )
        WHERE 
            groupID = '#CURRENT'";

    const GET_GROUPS = 
        "SELECT
            groupID AS groupId,
            count(guestID) AS groupMembers,
            (sum(score * !isDisqualified * !!finishTime) / (count(guestID) - sum(isDisqualified) - sum(!finishTime))) AS groupAvgScore,
            max(maxScore) AS maxScore,
            sum(isDisqualified) AS disqualifiedGroupMembers,
            min(startTime) AS groupStart,
            max(finishTime) AS groupEnd,
            category
        FROM
            scoreboard
        WHERE
            groupID != '#CURRENT'
        GROUP BY 
            groupID
        ORDER BY 
            groupStart DESC";

    const RATING_ADD = "UPDATE scoreboard SET quizRating = :rating WHERE guestID = :guestId AND isDisqualified = 0 AND score != 0";
    const GET_AVG_RATING = "SELECT avg(quizRating) AS 'rating' FROM scoreboard WHERE isDisqualified = 0 AND score != 0 AND quizRating != 0 AND finishTime != 0";

    const CHECK_IF_IP_AVAILABLE = "SELECT ip FROM scoreboard WHERE ip = :ip AND groupID = '#CURRENT'";
    const CHECK_IF_IS_DISQUALIFIED = "SELECT isDisqualified FROM scoreboard WHERE guestID = :guestId";

    const GET_VISITORS_SUMMARY = "SELECT count(guestID) AS guestsAmount, count(DISTINCT groupID) AS groupsAmount FROM scoreboard";

    public static function MERGE_GROUPS($groupsIds){

        $list = implode(", ", array_fill(0, count($groupsIds), "?"));
        return "UPDATE scoreboard SET groupID = '#CURRENT' WHERE groupID IN ($list)";
    }
    const REACTIVE_GROUP = "UPDATE scoreboard SET groupID = '#CURRENT' WHERE groupID = :groupId";
}