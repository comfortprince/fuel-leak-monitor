import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head, Link, useForm, usePage } from '@inertiajs/react';

import LineChart from './LineChart';

export default function Analytics({
    storageTank
}) {
    console.log(storageTank)

    const mq2Readings = storageTank.sensors.find(sensor => sensor.sensor_type === 'mq2').sensor_readings
    const bmp180Readings = storageTank.sensors.find(sensor => sensor.sensor_type === 'bmp180').sensor_readings

    return (
        <AuthenticatedLayout
            header={
                <h2 className="text-xl font-semibold leading-tight text-gray-800">
                    {`${storageTank.identifier} analytics`}
                </h2>
            }
        >
            <Head title="Dashboard" />

            <div className="py-12">
                <div className="mx-auto max-w-7xl sm:px-6 lg:px-8">

                    <div className="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                        <div className="p-6 text-gray-900">
                            <section className='mb-6'>
                                <div className='flex items-center justify-between mb-1.5'>
                                    <h3 className='text-lg font-bold'>
                                        Information
                                    </h3>
                                </div>
                                <div className='flex flex-col gap-y-1'>
                                    <div className='flex max-md:justify-between'>
                                        <div className='md:w-56 text-sm text-[hsl(0,0,30%)]'>
                                            Identifier
                                        </div>
                                        <div className='text-sm font-semibold'>
                                            {storageTank.identifier}
                                        </div>
                                    </div>
                                    <div className='flex max-md:justify-between'>
                                        <div className='md:w-56 text-sm text-[hsl(0,0,30%)]'>
                                            Fuel Type
                                        </div>
                                        <div className='text-sm font-semibold'>
                                            {storageTank.fuel_type}
                                        </div>
                                    </div>
                                    <div className='flex max-md:justify-between'>
                                        <div className='md:w-56 text-sm text-[hsl(0,0,30%)]'>
                                            Location
                                        </div>
                                        <div className='text-sm font-semibold'>
                                            {storageTank.location}
                                        </div>
                                    </div>
                                </div>
                            </section>
                            <section>
                                <div className='flex items-center justify-between mt-12'>
                                    <h3 className='text-lg font-bold'>
                                        BMP180 Sensor
                                    </h3>
                                </div>
                                <div>
                                    <LineChart 
                                        label={''} 
                                        data={bmp180Readings.map(bmp180Reading => {
                                            return {
                                                timestamp: bmp180Reading.timestamp,
                                                y_data: bmp180Reading.value
                                            }
                                        })}
                                    />
                                </div>
                            </section>
                            <section>
                                <div className='flex items-center justify-between mt-12'>
                                    <h3 className='text-lg font-bold'>
                                        MQ2 Sensor
                                    </h3>
                                </div>
                                <div>
                                    <LineChart 
                                        label={''}
                                        data={bmp180Readings.map(bmp180Reading => {
                                            return {
                                                timestamp: bmp180Reading.timestamp,
                                                y_data: bmp180Reading.value
                                            }
                                        })}
                                    />
                                </div>
                            </section>
                        </div>
                    </div>
                </div>
            </div>
        </AuthenticatedLayout>
    );
}
