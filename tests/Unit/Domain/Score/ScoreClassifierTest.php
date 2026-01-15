<?php

namespace Tests\Unit\Domain\Score;

use Tests\TestCase;
use App\Domain\Score\ScoreClassifier;

class ScoreClassifierTest extends TestCase
{
    public function test_classify_excellent_score()
    {
        $result = ScoreClassifier::classify(8.5);
        $this->assertEquals(ScoreClassifier::LEVEL_EXCELLENT, $result);

        $result = ScoreClassifier::classify(10.0);
        $this->assertEquals(ScoreClassifier::LEVEL_EXCELLENT, $result);

        $result = ScoreClassifier::classify(8.0);
        $this->assertEquals(ScoreClassifier::LEVEL_EXCELLENT, $result);
    }

    public function test_classify_good_score()
    {
        $result = ScoreClassifier::classify(7.5);
        $this->assertEquals(ScoreClassifier::LEVEL_GOOD, $result);

        $result = ScoreClassifier::classify(6.0);
        $this->assertEquals(ScoreClassifier::LEVEL_GOOD, $result);

        $result = ScoreClassifier::classify(6.5);
        $this->assertEquals(ScoreClassifier::LEVEL_GOOD, $result);
    }

    public function test_classify_average_score()
    {
        $result = ScoreClassifier::classify(5.0);
        $this->assertEquals(ScoreClassifier::LEVEL_AVERAGE, $result);

        $result = ScoreClassifier::classify(4.0);
        $this->assertEquals(ScoreClassifier::LEVEL_AVERAGE, $result);

        $result = ScoreClassifier::classify(4.5);
        $this->assertEquals(ScoreClassifier::LEVEL_AVERAGE, $result);
    }

    public function test_classify_weak_score()
    {
        $result = ScoreClassifier::classify(3.5);
        $this->assertEquals(ScoreClassifier::LEVEL_WEAK, $result);

        $result = ScoreClassifier::classify(0.0);
        $this->assertEquals(ScoreClassifier::LEVEL_WEAK, $result);

        $result = ScoreClassifier::classify(2.0);
        $this->assertEquals(ScoreClassifier::LEVEL_WEAK, $result);
    }

    public function test_classify_null_score()
    {
        $result = ScoreClassifier::classify(null);
        $this->assertNull($result);
    }
}
