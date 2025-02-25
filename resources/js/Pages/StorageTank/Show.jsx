import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head, Link } from '@inertiajs/react';

import PrimaryButton from '@/Components/PrimaryButton';
import SecondaryButton from '@/Components/SecondaryButton';
import DangerButton from '@/Components/DangerButton';

import Table from '@mui/material/Table';
import TableBody from '@mui/material/TableBody';
import TableCell from '@mui/material/TableCell';
import TableContainer from '@mui/material/TableContainer';
import TableHead from '@mui/material/TableHead';
import TableRow from '@mui/material/TableRow';

export default function Show({
    storageTank
}) {
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
                    <div className="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                        <div className="p-6 text-gray-900">
                            <section className='mb-6'>
                                <div className='flex items-center justify-between mb-1.5'>
                                    <h3 className='text-base font-bold'>
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
                                <div className='flex items-center justify-between'>
                                    <h3 className='text-base font-bold'>
                                        Sensors
                                    </h3>
                                    <Link
                                        href={route('sensors.create')}
                                    >
                                        <PrimaryButton>
                                            New
                                        </PrimaryButton>
                                    </Link>
                                </div>
                                <TableContainer sx={{ mt: '0' }}>
                                    <Table sx={{ minWidth: 650 }} aria-label="simple table">
                                        <TableHead>
                                        <TableRow>
                                            <TableCell sx={{ pl: '0'}}>Identifier</TableCell>
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
                                                sx={{ pl: '0'}}
                                            >
                                                {sensor.identifier}
                                            </TableCell>
                                            <TableCell align="left">{sensor.sensor_type}</TableCell>
                                            <TableCell align="left">
                                                {sensor.last_seen ? sensor.last_seen : 'inactive'}
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
                        </div>
                    </div>
                </div>
            </div>
        </AuthenticatedLayout>
    );
}
