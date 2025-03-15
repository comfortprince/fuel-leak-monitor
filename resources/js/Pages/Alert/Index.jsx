import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head, Link, useForm, usePage } from '@inertiajs/react';

import Table from '@mui/material/Table';
import TableBody from '@mui/material/TableBody';
import TableCell from '@mui/material/TableCell';
import TableContainer from '@mui/material/TableContainer';
import TableHead from '@mui/material/TableHead';
import TableRow from '@mui/material/TableRow';
import { Paper } from '@mui/material';

import PrimaryButton from '@/Components/PrimaryButton';
import StatusBadge from '@/Components/StatusBadge';
import { useEffect, useState } from 'react';

export default function Index({
  _alerts
}) {
    const { put } = useForm({});
    const { flash } = usePage().props;
    const [alerts, setAlerts] = useState(_alerts);

    useEffect(()=>{
      console.log(alerts)
      const channel = Echo.private(`fuelLeakAlerts`);
      
      channel.listen('FuelLeakAlert', (e) => {
        console.log(e.alert);
        setAlerts([...alerts, e.alert]);
      });

      return () => {
        Echo.private(`fuelLeakAlerts`).stopListening('FuelLeakAlert')
      }
    },[])

    return (
        <AuthenticatedLayout
            header={
                <h2 className="text-xl font-semibold leading-tight text-gray-800">
                  Alerts
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
                          <TableContainer component={Paper}>
                            <Table sx={{ minWidth: 650 }} aria-label="simple table">
                              <TableHead>
                                <TableRow>
                                  <TableCell>Tank</TableCell>
                                  <TableCell align="right">Description</TableCell>
                                  <TableCell align="right">Level</TableCell>
                                  <TableCell align="right">Action Required</TableCell>
                                  <TableCell align="right">Status</TableCell>
                                  <TableCell align="right">MQ2 Value</TableCell>
                                  <TableCell align="right">BMP180 Value</TableCell>
                                  <TableCell align="right">Triggered At</TableCell>
                                </TableRow>
                            </TableHead>
                            <TableBody>
                                {alerts.map((alert) => (
                                  <TableRow
                                    key={alert.id}
                                    sx={{ '&:last-child td, &:last-child th': { border: 0 } }}
                                  >
                                    <TableCell component="th" scope="row">
                                      <span className="whitespace-nowrap">
                                        {alert.custom_alert.storage_tank.identifier}
                                      </span>
                                    </TableCell>
                                    <TableCell align="right">
                                      {alert.custom_alert.description}
                                    </TableCell>
                                    <TableCell align="right">{ <StatusBadge status={alert.custom_alert.level} />}</TableCell>
                                    <TableCell align="right">{alert.custom_alert.action_required}</TableCell>
                                    <TableCell align="right">
                                      {alert.status === 'unresolved' ? 
                                        <PrimaryButton 
                                          onClick={() => { put(route('alerts.resolve', alert.id)) }}
                                        > 
                                          Resolve 
                                        </PrimaryButton>
                                        : <StatusBadge status={'resolved'}/> }
                                    </TableCell>
                                    <TableCell align="right">{alert.mq2_reading.value}</TableCell>
                                    <TableCell align="right">{alert.bmp180_reading.value}</TableCell>
                                    <TableCell align="right">{alert.triggered_at}</TableCell>
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
