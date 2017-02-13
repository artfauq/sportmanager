<?php if(isset($workouts)){
     foreach ($workouts as $workout) {
         echo json_encode($workout['Workout']['description']);
     }
}else{
    echo json_encode($message);
}

if(isset($futureWorkout)){
    echo json_encode($futureWorkout['Workout']['description']);
}
