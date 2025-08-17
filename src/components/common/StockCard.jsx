import React from 'react';
import { TrendingUp, TrendingDown, Plus } from 'lucide-react';
import { Card } from '../ui/card';
import { Button } from '../ui/button';

const StockCard = ({ 
  stock, 
  showAddToWatchlist = false,
  onAddToWatchlist,
  onClick,
  className = ""
}) => {
  const isPositive = stock.change_percent > 0;
  
  const formatPrice = (price) => {
    return price ? `$${price.toFixed(2)}` : 'N/A';
  };

  const formatPercent = (percent) => {
    if (!percent) return '0.00%';
    const sign = percent > 0 ? '+' : '';
    return `${sign}${percent.toFixed(2)}%`;
  };

  const formatVolume = (volume) => {
    if (!volume) return 'N/A';
    if (volume >= 1000000) return `${(volume / 1000000).toFixed(1)}M`;
    if (volume >= 1000) return `${(volume / 1000).toFixed(1)}K`;
    return volume.toLocaleString();
  };

  return (
    <Card 
      className={`p-6 hover:shadow-lg transition-all duration-200 cursor-pointer ${className}`}
      onClick={onClick}
    >
      {/* Header */}
      <div className="flex justify-between items-start mb-4">
        <div className="min-w-0 flex-1">
          <h3 className="text-lg font-bold text-slate-900 truncate">
            {stock.ticker || stock.symbol}
          </h3>
          <p className="text-sm text-slate-600 truncate">
            {stock.company_name || stock.name}
          </p>
        </div>
        
        <div className="flex items-center space-x-2 ml-4">
          {showAddToWatchlist && onAddToWatchlist && (
            <Button
              size="sm"
              variant="outline"
              onClick={(e) => {
                e.stopPropagation();
                onAddToWatchlist(stock.ticker || stock.symbol);
              }}
              className="h-8 w-8 p-0"
            >
              <Plus className="h-4 w-4" />
            </Button>
          )}
          
          <div className={`flex items-center ${isPositive ? 'text-green-600' : 'text-red-600'}`}>
            {isPositive ? (
              <TrendingUp className="h-4 w-4 mr-1" />
            ) : (
              <TrendingDown className="h-4 w-4 mr-1" />
            )}
          </div>
        </div>
      </div>

      {/* Price */}
      <div className="mb-4">
        <div className="flex items-baseline space-x-2">
          <span className="text-2xl font-bold text-slate-900">
            {formatPrice(stock.current_price || stock.price)}
          </span>
          <span className={`text-lg font-semibold ${isPositive ? 'text-green-600' : 'text-red-600'}`}>
            {formatPercent(stock.change_percent)}
          </span>
        </div>
        {stock.price_change_today && (
          <p className={`text-sm ${isPositive ? 'text-green-600' : 'text-red-600'}`}>
            {isPositive ? '+' : ''}{formatPrice(stock.price_change_today)} today
          </p>
        )}
      </div>

      {/* Details */}
      <div className="grid grid-cols-2 gap-4 text-sm">
        <div>
          <span className="text-slate-600">Volume</span>
          <p className="font-medium text-slate-900">
            {formatVolume(stock.volume)}
          </p>
        </div>
        <div>
          <span className="text-slate-600">Market Cap</span>
          <p className="font-medium text-slate-900">
            {stock.market_cap_formatted || 'N/A'}
          </p>
        </div>
        {(stock.pe_ratio || stock.week_52_high) && (
          <>
            <div>
              <span className="text-slate-600">P/E Ratio</span>
              <p className="font-medium text-slate-900">
                {stock.pe_ratio ? stock.pe_ratio.toFixed(2) : 'N/A'}
              </p>
            </div>
            <div>
              <span className="text-slate-600">52W High</span>
              <p className="font-medium text-slate-900">
                {stock.week_52_high ? formatPrice(stock.week_52_high) : 'N/A'}
              </p>
            </div>
          </>
        )}
      </div>
    </Card>
  );
};

export default StockCard;