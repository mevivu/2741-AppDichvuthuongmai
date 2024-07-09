<span @class([ 'badge' , 'bg-danger-lt'=> \App\Enums\Vehicle\VehicleType::Unclassified == $type,
    ])>{{ \App\Enums\Vehicle\VehicleType::getDescription($type) }}</span>
