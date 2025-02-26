import { Head, Link, useForm, usePage } from '@inertiajs/react';

import Table from '@mui/material/Table';
import TableBody from '@mui/material/TableBody';
import TableCell from '@mui/material/TableCell';
import TableContainer from '@mui/material/TableContainer';
import TableHead from '@mui/material/TableHead';
import TableRow from '@mui/material/TableRow';

import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import PrimaryButton from '@/Components/PrimaryButton';
import SecondaryButton from '@/Components/SecondaryButton';
import DangerButton from '@/Components/DangerButton';

export default function Index({
    storageTanks
}) {
    const { delete: destroy } = useForm({});
    const { flash } = usePage().props

    return (
      <AuthenticatedLayout
        header={
          <div className='flex items-center justify-between'>
            <h2 className="text-xl font-semibold leading-tight text-gray-800">
              Storage Tanks
            </h2>
            <Link href={route('storage-tanks.create')}>
              <PrimaryButton>
                New
              </PrimaryButton>
            </Link>
          </div>
        }
      >
    <Head title="Storage Tanks" />

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
                <TableContainer >
                  <Table sx={{ minWidth: 650 }} aria-label="simple table">
                    <TableHead>
                      <TableRow>
                        <TableCell>Identifier</TableCell>
                        <TableCell align="right">Fuel Type</TableCell>
                        <TableCell align="right">Location</TableCell>
                        <TableCell align="right">Analytics</TableCell>
                        <TableCell align="right">Actions</TableCell>
                      </TableRow>
                  </TableHead>
                  <TableBody>
                      {storageTanks.map((storageTank) => (
                        <TableRow
                          key={storageTank.identifier}
                          sx={{ '&:last-child td, &:last-child th': { border: 0 } }}
                        >
                          <TableCell component="th" scope="row">
                            <Link href={route('storage-tanks.show', storageTank.id)}>
                              {storageTank.identifier}
                            </Link>
                          </TableCell>
                          <TableCell align="right">{storageTank.fuel_type}</TableCell>
                          <TableCell align="right">{storageTank.location}</TableCell>
                          <TableCell align="right">
                            <Link href={route('storage-tanks.analytics', storageTank.id)}>
                              <PrimaryButton>
                                Analytics
                              </PrimaryButton>
                            </Link>
                          </TableCell>
                          <TableCell align="right">
                            <div className='inline-flex gap-x-2'>
                              <Link href={route('storage-tanks.edit', storageTank.id)}>
                                <SecondaryButton>
                                  Edit
                                </SecondaryButton>
                              </Link>
                              <form 
                                onSubmit={(e) => {
                                  e.preventDefault();
                                  destroy(route('storage-tanks.destroy', storageTank.id))
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
              </div>
            </div>
          </div>
        </div>
      </AuthenticatedLayout>
    );
}