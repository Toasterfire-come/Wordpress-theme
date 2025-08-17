import React from 'react';
import { XCircle, ArrowLeft } from 'lucide-react';
import Layout from '../components/common/Layout';
import { Card } from '../components/ui/card';
import { Button } from '../components/ui/button';

const PaymentCancelled = () => {
  return (
    <Layout>
      <div className="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <Card className="p-8 text-center">
          <div className="w-16 h-16 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-6">
            <XCircle className="h-8 w-8 text-red-600" />
          </div>
          <h1 className="text-2xl font-bold text-slate-900 mb-4">Payment Cancelled</h1>
          <p className="text-slate-600 mb-8">
            Your payment was cancelled. You can try again or contact support if you need assistance.
          </p>
          <Button onClick={() => window.location.href = '/premium'}>
            <ArrowLeft className="h-4 w-4 mr-2" />
            Back to Plans
          </Button>
        </Card>
      </div>
    </Layout>
  );
};

export default PaymentCancelled;