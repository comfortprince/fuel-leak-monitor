import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head, Link, useForm, usePage } from '@inertiajs/react';

import PrimaryButton from '@/Components/PrimaryButton';
import SecondaryButton from '@/Components/SecondaryButton';
import DangerButton from '@/Components/DangerButton';
import StatusBadge from '@/Components/StatusBadge';

import Table from '@mui/material/Table';
import TableBody from '@mui/material/TableBody';
import TableCell from '@mui/material/TableCell';
import TableContainer from '@mui/material/TableContainer';
import TableHead from '@mui/material/TableHead';
import TableRow from '@mui/material/TableRow';
import Paper from '@mui/material/Paper';

export default function Show({
    storageTank
}) {
    const { delete: destroy } = useForm({});
    const { flash } = usePage().props

    return (
        <AuthenticatedLayout
            header={
                <h2 className="text-xl font-semibold leading-tight text-gray-800">
                    {storageTank.identifier}
                </h2>
            }
        >
            <Head title="Dashboard" />

            <div className="py-12">
                <div className="mx-auto max-w-7xl sm:px-6 lg:px-8">
                    {flash.message &&
                        <div className="p-6 bg-white mb-6 sm:rounded-lg">
                            <div className="p-4 border border-green-400 bg-green-100 text-green-800 flex items-center gap-2">
                                <svg className="w-6 h-6 text-green-600" fill="none" stroke="currentColor" strokeWidth="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path strokeLinecap="round" strokeLinejoin="round" d="M5 13l4 4L19 7"></path>
                                </svg>
                                <span>{flash.message}</span>
                            </div>
                        </div>
                    }

                    <div className="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                        <div className="p-6 text-gray-900">
                            <section className='mb-6'>
                                <div className='flex items-center justify-between mb-1.5'>
                                    <h3 className='text-lg font-bold'>
                                        Information
                                    </h3>
                                    <Link
                                        href={route('storage-tanks.edit', storageTank.id)}
                                    >
                                        <SecondaryButton>
                                            Edit
                                        </SecondaryButton>
                                    </Link>
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
                                        Sensors
                                    </h3>
                                    <Link
                                        href={storageTank.sensors.length > 1 ? '#!' : route('sensors.create')}
                                    >
                                        <PrimaryButton disabled>
                                            New
                                        </PrimaryButton>
                                    </Link>
                                </div>
                                <TableContainer sx={{ mt: '1rem' }} component={Paper}>
                                    <Table sx={{ minWidth: 650 }} aria-label="simple table">
                                        <TableHead>
                                        <TableRow>
                                            <TableCell >Identifier</TableCell>
                                            <TableCell align="left">Type</TableCell>
                                            <TableCell align="left">Last Seen</TableCell>
                                            <TableCell align="left">Actions</TableCell>
                                        </TableRow>
                                    </TableHead>
                                    <TableBody>
                                        {storageTank.sensors.map((sensor) => (
                                            <TableRow
                                                key={sensor.identifier}
                                                sx={{ '&:last-child td, &:last-child th': { border: 0 } }}
                                            >
                                            <TableCell 
                                                component="th" 
                                                scope="row"
                                            >
                                                {sensor.identifier}
                                            </TableCell>
                                            <TableCell align="left">{sensor.sensor_type}</TableCell>
                                            <TableCell align="left">
                                                {sensor.last_seen ? sensor.last_seen : <StatusBadge status={'inactive'}/>}
                                            </TableCell>
                                            <TableCell align="left">
                                                <div className='inline-flex gap-x-2'>
                                                    <Link href={route('storage-tanks.show', sensor.id)}>
                                                        <PrimaryButton>
                                                            Readings
                                                        </PrimaryButton>
                                                    </Link>
                                                    <form 
                                                        onSubmit={(e) => {
                                                        e.preventDefault();
                                                        destroy(route('storage-tanks.destroy', sensor.id))
                                                        }}
                                                    >
                                                        <DangerButton>
                                                            Delete
                                                        </DangerButton>
                                                    </form>
                                                </div>
                                            </TableCell>
                                            </TableRow>
                                        ))}
                                        </TableBody>
                                    </Table>
                                </TableContainer>
                            </section>
                            <section>
                                <div className='flex items-center justify-between mt-12'>
                                    <h3 className='text-lg font-bold'>
                                        Custom Alerts
                                    </h3>
                                    <Link
                                        href={route('custom-alerts.create')}
                                    >
                                        <PrimaryButton>
                                            New
                                        </PrimaryButton>
                                    </Link>
                                </div>
                                <TableContainer sx={{ mt: '1rem' }} component={Paper}>
                                    <Table sx={{ minWidth: 650 }} aria-label="simple table">
                                        <TableHead>
                                        <TableRow>
                                            <TableCell >MQ2 Min (ppm)</TableCell>
                                            <TableCell align="left">MQ2 Max (ppm)</TableCell>
                                            <TableCell align="left">BMP180 Min (Pa)</TableCell>
                                            <TableCell align="left">BMP180 Max (Pa)</TableCell>
                                            <TableCell align="left">Level</TableCell>
                                            <TableCell align="left">Description</TableCell>
                                            <TableCell align="left">Action Required</TableCell>
                                            <TableCell align="left">Actions</TableCell>
                                        </TableRow>
                                    </TableHead>
                                    <TableBody>
                                        {storageTank.custom_alerts.map((customAlert) => (
                                            <TableRow
                                                key={customAlert.id}
                                                sx={{ '&:last-child td, &:last-child th': { border: 0 } }}
                                            >
                                                <TableCell 
                                                    component="th" 
                                                    scope="row"
                                                >
                                                    {customAlert.mq2_min}
                                                </TableCell>
                                                <TableCell align="left">{customAlert.mq2_max}</TableCell>
                                                <TableCell align="left">
                                                    {customAlert.bmp180_min}
                                                </TableCell>
                                                <TableCell align="left">
                                                    {customAlert.bmp180_max}
                                                </TableCell>
                                                <TableCell align="left"> <StatusBadge status={customAlert.level}/> </TableCell>
                                                <TableCell align="left">
                                                    {customAlert.description}
                                                </TableCell>
                                                <TableCell align="left">
                                                    {customAlert.action_required}
                                                </TableCell>
                                                <TableCell align="left">
                                                    <div className='inline-flex gap-x-2'>
                                                        <Link href={route('custom-alerts.edit', customAlert.id)}>
                                                            <PrimaryButton>
                                                                Edit
                                                            </PrimaryButton>
                                                        </Link>
                                                        <form 
                                                            onSubmit={(e) => {
                                                                e.preventDefault();
                                                                destroy(route('custom-alerts.destroy', customAlert.id))
                                                            }}
                                                        >
                                                            <DangerButton>
                                                                Delete
                                                            </DangerButton>
                                                        </form>
                                                    </div>
                                                </TableCell>
                                            </TableRow>
                                        ))}
                                        </TableBody>
                                    </Table>
                                </TableContainer>
                            </section>
                        </div>
                    </div>
                </div>
            </div>
        </AuthenticatedLayout>
    );
}
